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

    function easeOutCubic(t) {
      return 1 - Math.pow(1 - t, 3);
    }

    function animateEl(el) {
      var raw = el.getAttribute('data-target') || '0';
      var target = parseInt(raw, 10);
      if (isNaN(target) || target < 0) target = 0;
      var start = performance.now();
      var duration = 1100;
      function frame(now) {
        var p = Math.min(1, (now - start) / duration);
        var v = Math.round(target * easeOutCubic(p));
        el.textContent = String(v);
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
    }, { threshold: 0.2, rootMargin: '0px 0px -40px 0px' });
    io.observe(root);
  }

  bindContactTabs();
  bindHeaderScrollState();
  bindHomeStatsCountUp();
})();