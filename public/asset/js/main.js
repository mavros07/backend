(function () {
  'use strict';

  var menuToggle = document.querySelector('[data-mobile-menu-toggle]');
  var menuPanel = document.querySelector('[data-mobile-menu-panel]');
  var menuOverlay = document.querySelector('[data-mobile-menu-overlay]');
  var menuClose = document.querySelector('[data-mobile-menu-close]');

  function setMenu(open) {
    if (!menuPanel || !menuOverlay) return;
    menuPanel.classList.toggle('is-open', open);
    menuOverlay.classList.toggle('hidden', !open);
    document.body.classList.toggle('mobile-menu-open', open);
  }

  if (menuToggle && menuPanel && menuOverlay) {
    menuToggle.addEventListener('click', function () { setMenu(true); });
    menuOverlay.addEventListener('click', function () { setMenu(false); });
    if (menuClose) {
      menuClose.addEventListener('click', function () { setMenu(false); });
    }
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setMenu(false);
    });
  }

  function bindHeaderScrollState() {
    var header = document.querySelector('[data-site-header]');
    if (!header) return;

    function sync() {
      var scrolled = window.scrollY > 10;
      header.classList.toggle('is-scrolled', scrolled);
    }

    sync();
    window.addEventListener('scroll', sync, { passive: true });
  }

  function bindContactTabs() {
    var tabButtons = document.querySelectorAll('[data-contact-tab]');
    if (!tabButtons.length) return;

    function activateTab(name) {
      tabButtons.forEach(function (tab) {
        var active = tab.getAttribute('data-contact-tab') === name;
        tab.classList.toggle('bg-white', active);
        tab.classList.toggle('text-slate-900', active);
        tab.classList.toggle('border-t-2', active);
        tab.classList.toggle('border-brand_orange', active);
      });

      document.querySelectorAll('[data-contact-panel]').forEach(function (panel) {
        panel.classList.toggle('hidden', panel.getAttribute('data-contact-panel') !== name);
      });
    }

    tabButtons.forEach(function (tab) {
      tab.addEventListener('click', function () {
        activateTab(tab.getAttribute('data-contact-tab'));
      });
    });

    activateTab(tabButtons[0].getAttribute('data-contact-tab'));
  }

  function bindHomeStatsCountUp() {
    var root = document.querySelector('[data-home-stats-root]');
    if (!root) return;
    var els = root.querySelectorAll('[data-count-up]');
    if (!els.length) return;

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return;
    }

    function easeOutCubic(t) {
      return 1 - Math.pow(1 - t, 3);
    }

    function formatStat(n) {
      return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function animateEl(el) {
      var rawT = el.getAttribute('data-target') || '0';
      var target = parseInt(rawT, 10);
      if (isNaN(target) || target < 0) target = 0;
      var from = 0;
      el.textContent = '0';
      var start = performance.now();
      var duration = 1100;
      function frame(now) {
        var p = Math.min(1, (now - start) / duration);
        var t = easeOutCubic(p);
        var v = Math.round(from + (target - from) * t);
        el.textContent = formatStat(v);
        if (p < 1) requestAnimationFrame(frame);
      }
      requestAnimationFrame(frame);
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        io.disconnect();
        els.forEach(function (el) {
          animateEl(el);
        });
      });
    }, { threshold: 0.3, rootMargin: '0px 0px -10% 0px' });
    io.observe(root);
  }

  /**
   * Listing cards: 2D hover/touch zones (row × column) map to gallery images — horizontal and
   * vertical movement both change the photo, similar to Motors interactive listings.
   */
  function bindListingHoverGalleries() {
    var wraps = document.querySelectorAll('[data-vehicle-hover-gallery]');
    if (!wraps.length) return;

    var reduceMotion =
      window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    wraps.forEach(function (wrap) {
      var raw = wrap.getAttribute('data-images') || '[]';
      var urls;
      try {
        urls = JSON.parse(raw);
      } catch (e) {
        return;
      }
      if (!Array.isArray(urls) || urls.length < 2) return;

      var img = wrap.querySelector('[data-vehicle-hover-main]');
      if (!img) return;

      var n = urls.length;
      var dots = wrap.querySelectorAll('[data-vehicle-hover-dot]');
      var current = 0;

      urls.forEach(function (u) {
        var pre = new Image();
        pre.src = u;
      });

      function setIndex(i) {
        i = Math.max(0, Math.min(n - 1, i));
        if (i === current) return;
        current = i;
        img.src = urls[i];
        dots.forEach(function (dot, di) {
          dot.setAttribute('data-active', di === i ? '1' : '0');
        });
      }

      function clientXYFromEvent(e) {
        if (e.touches && e.touches[0]) {
          return { x: e.touches[0].clientX, y: e.touches[0].clientY };
        }
        if (e.changedTouches && e.changedTouches[0]) {
          return { x: e.changedTouches[0].clientX, y: e.changedTouches[0].clientY };
        }
        return { x: e.clientX, y: e.clientY };
      }

      function indexFromPoint(x, y, w, h) {
        var cols = Math.ceil(Math.sqrt(n));
        var rows = Math.ceil(n / cols);
        var cx = Math.min(cols - 1, Math.max(0, Math.floor((x / w) * cols)));
        var cy = Math.min(rows - 1, Math.max(0, Math.floor((y / h) * rows)));
        var idx = cy * cols + cx;
        return Math.min(n - 1, idx);
      }

      function onMove(e) {
        if (reduceMotion) return;
        var rect = wrap.getBoundingClientRect();
        if (rect.width <= 0 || rect.height <= 0) return;
        var p = clientXYFromEvent(e);
        var x = p.x - rect.left;
        var y = p.y - rect.top;
        setIndex(indexFromPoint(x, y, rect.width, rect.height));
      }

      function reset() {
        setIndex(0);
      }

      wrap.addEventListener('mousemove', onMove);
      wrap.addEventListener('mouseleave', reset);
      wrap.addEventListener('touchstart', onMove, { passive: true });
      wrap.addEventListener('touchmove', onMove, { passive: true });
      wrap.addEventListener('touchend', reset);
      wrap.addEventListener('touchcancel', reset);
    });
  }

  /**
   * Simple scroll-snap carousel: About page gallery/testimonials.
   * Markup:
   * - root: [data-simple-carousel]
   * - track: [data-carousel-track]
   * - slides: children with [data-carousel-slide]
   * - prev/next buttons: [data-carousel-prev], [data-carousel-next]
   * - dots: [data-carousel-dot] with data-index
   */
  function bindSimpleCarousels() {
    var roots = document.querySelectorAll('[data-simple-carousel]');
    if (!roots.length) return;

    function clamp(n, min, max) { return Math.max(min, Math.min(max, n)); }

    roots.forEach(function (root) {
      var track = root.querySelector('[data-carousel-track]');
      if (!track) return;
      var slides = track.querySelectorAll('[data-carousel-slide]');
      if (!slides.length) return;

      var prev = root.querySelector('[data-carousel-prev]');
      var next = root.querySelector('[data-carousel-next]');
      var dots = root.querySelectorAll('[data-carousel-dot]');

      function nearestIndex() {
        var left = track.scrollLeft;
        var best = 0;
        var bestDist = Infinity;
        slides.forEach(function (s, i) {
          var dist = Math.abs(s.offsetLeft - left);
          if (dist < bestDist) { bestDist = dist; best = i; }
        });
        return best;
      }

      function setActive(i) {
        dots.forEach(function (d) {
          var di = parseInt(d.getAttribute('data-index') || '0', 10);
          d.setAttribute('data-active', di === i ? '1' : '0');
        });
      }

      function goTo(i) {
        i = clamp(i, 0, slides.length - 1);
        track.scrollTo({ left: slides[i].offsetLeft, behavior: 'smooth' });
        setActive(i);
      }

      function step(dir) {
        var i = nearestIndex();
        goTo(i + dir);
      }

      prev && prev.addEventListener('click', function (e) { e.preventDefault(); step(-1); });
      next && next.addEventListener('click', function (e) { e.preventDefault(); step(1); });

      dots.forEach(function (d) {
        d.addEventListener('click', function (e) {
          e.preventDefault();
          var i = parseInt(d.getAttribute('data-index') || '0', 10);
          if (!isNaN(i)) goTo(i);
        });
      });

      var ticking = false;
      track.addEventListener('scroll', function () {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(function () {
          ticking = false;
          setActive(nearestIndex());
        });
      }, { passive: true });

      setActive(0);
    });
  }

  bindContactTabs();
  bindHeaderScrollState();
  bindHomeStatsCountUp();
  bindListingHoverGalleries();
  bindSimpleCarousels();
})();