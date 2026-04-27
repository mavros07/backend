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
   * - viewport (overflow hidden): [data-carousel-viewport]
   * - track: [data-carousel-track]
   * - slides: children with [data-carousel-slide]
   * - prev/next buttons: [data-carousel-prev], [data-carousel-next]
   * - dots container: [data-carousel-dots] (dots will be generated)
   */
  function bindSimpleCarousels() {
    var roots = document.querySelectorAll('[data-simple-carousel]');
    if (!roots.length) return;

    function clamp(n, min, max) { return Math.max(min, Math.min(max, n)); }

    roots.forEach(function (root) {
      var type = root.getAttribute('data-carousel-type') || '';
      var viewport = root.querySelector('[data-carousel-viewport]') || root;
      var track = root.querySelector('[data-carousel-track]');
      if (!track) return;
      var slides = track.querySelectorAll('[data-carousel-slide]');
      if (!slides.length) return;

      var prev = root.querySelector('[data-carousel-prev]');
      var next = root.querySelector('[data-carousel-next]');
      var dotsWrap = root.querySelector('[data-carousel-dots]');
      var index = 0;

      function px(v) { return parseFloat(String(v || '0').replace('px', '')) || 0; }

      function metrics() {
        var first = slides[0];
        var slideW = first.getBoundingClientRect().width || first.offsetWidth || 0;
        var gap = px(window.getComputedStyle(track).gap);
        var viewW = viewport.getBoundingClientRect().width || viewport.offsetWidth || 0;
        var perView = Math.max(1, Math.floor((viewW + gap) / Math.max(1, (slideW + gap))));
        if (type === 'testimonials') {
          perView = 1;
        }
        var maxIndex = Math.max(0, slides.length - perView);
        return { slideW: slideW, gap: gap, perView: perView, maxIndex: maxIndex };
      }

      function buildDots(pageCount) {
        if (!dotsWrap) return [];
        dotsWrap.innerHTML = '';
        var dots = [];
        for (var i = 0; i < pageCount; i++) {
          var b = document.createElement('button');
          b.type = 'button';
          b.setAttribute('data-index', String(i));
          b.setAttribute('data-active', i === 0 ? '1' : '0');
          b.setAttribute('aria-label', 'Go to slide');
          b.addEventListener('click', function (e) {
            e.preventDefault();
            var di = parseInt(this.getAttribute('data-index') || '0', 10);
            if (!isNaN(di)) goTo(di);
          });
          dotsWrap.appendChild(b);
          dots.push(b);
        }
        return dots;
      }

      var dots = [];

      function setActive(i, maxIndex) {
        if (prev) prev.disabled = i <= 0;
        if (next) next.disabled = i >= maxIndex;
        dots.forEach(function (d, di) {
          d.setAttribute('data-active', di === i ? '1' : '0');
        });
      }

      function applyTransform(i) {
        var m = metrics();
        index = clamp(i, 0, m.maxIndex);
        var x = (m.slideW + m.gap) * index;
        track.style.transform = 'translate3d(' + (-x) + 'px,0,0)';
        setActive(index, m.maxIndex);
      }

      function goTo(i) { applyTransform(i); }

      function step(dir) { goTo(index + dir); }

      prev && prev.addEventListener('click', function (e) { e.preventDefault(); step(-1); });
      next && next.addEventListener('click', function (e) { e.preventDefault(); step(1); });

      function rebuild() {
        var m = metrics();
        dots = buildDots(m.maxIndex + 1);
        applyTransform(index);
      }

      // Touch swipe (Motors/Swiper-like feel on mobile)
      (function bindSwipe() {
        var startX = 0;
        var startY = 0;
        var active = false;
        var moved = false;

        function onStart(e) {
          if (!e.touches || !e.touches[0]) return;
          active = true;
          moved = false;
          startX = e.touches[0].clientX;
          startY = e.touches[0].clientY;
        }

        function onMove(e) {
          if (!active || !e.touches || !e.touches[0]) return;
          var dx = e.touches[0].clientX - startX;
          var dy = e.touches[0].clientY - startY;
          if (Math.abs(dx) > 12 && Math.abs(dx) > Math.abs(dy)) {
            moved = true;
          }
        }

        function onEnd(e) {
          if (!active) return;
          active = false;
          if (!moved) return;
          var t = (e.changedTouches && e.changedTouches[0]) ? e.changedTouches[0] : null;
          if (!t) return;
          var dx = t.clientX - startX;
          if (Math.abs(dx) < 40) return;
          step(dx < 0 ? 1 : -1);
        }

        viewport.addEventListener('touchstart', onStart, { passive: true });
        viewport.addEventListener('touchmove', onMove, { passive: true });
        viewport.addEventListener('touchend', onEnd, { passive: true });
        viewport.addEventListener('touchcancel', function () { active = false; }, { passive: true });
      })();

      window.addEventListener('resize', function () { rebuild(); }, { passive: true });
      rebuild();
    });
  }

  bindContactTabs();
  bindHeaderScrollState();
  bindHomeStatsCountUp();
  bindListingHoverGalleries();
  bindSimpleCarousels();
})();