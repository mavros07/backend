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

  bindContactTabs();
})();