(function () {
  'use strict';

  var root = document.documentElement;
  root.classList.remove('stm-site-preloader');
  root.classList.add('stm-site-preloaded');

  var trigger = document.querySelector('.stm-menu-boats-trigger');
  var menu = document.querySelector('.stm-boats-mobile-menu');
  if (trigger && menu) {
    trigger.addEventListener('click', function () {
      document.body.classList.toggle('static-mobile-menu-open');
      trigger.classList.toggle('static-active');
    });
  }

  function initHoverableGalleries() {
    var galleries = document.querySelectorAll('.interactive-hoverable');
    if (!galleries.length) return;

    galleries.forEach(function (gallery) {
      var wrap = gallery.querySelector('.hoverable-wrap');
      var units = Array.prototype.slice.call(
        gallery.querySelectorAll('.hoverable-wrap .hoverable-unit')
      );
      if (!wrap || units.length < 2) return;

      var indicators = Array.prototype.slice.call(
        gallery.querySelectorAll('.hoverable-indicators .indicator')
      );

      function setActive(idx) {
        for (var i = 0; i < units.length; i++) {
          units[i].classList.toggle('active', i === idx);
        }
        for (var j = 0; j < indicators.length; j++) {
          indicators[j].classList.toggle('active', j === idx);
        }
      }

      function indexFromMouseEvent(e) {
        var rect = wrap.getBoundingClientRect();
        var n = units.length;
        if (!rect.width || n <= 1) return 0;
        var x = e.clientX - rect.left;
        var raw = Math.floor((x / rect.width) * n);
        if (raw < 0) return 0;
        if (raw >= n) return n - 1;
        return raw;
      }

      gallery.addEventListener(
        'mousemove',
        function (e) {
          setActive(indexFromMouseEvent(e));
        },
        { passive: true }
      );
      gallery.addEventListener(
        'mouseleave',
        function () {
          setActive(0);
        },
        { passive: true }
      );

      for (var k = 0; k < indicators.length; k++) {
        (function (idx) {
          indicators[idx].addEventListener(
            'mouseenter',
            function () {
              setActive(idx);
            },
            { passive: true }
          );
        })(k);
      }
    });
  }

  function normalizeListingLinks() {
    var oldDetailsSlug = 'listing-2016-mercedes-benz-c-class-c300-4matic.html';
    var inventoryPath = '/inventory';
    var remoteListingPrefix =
      'https://motors.stylemixthemes.com/elementor-dealer-two/listings/';

    var anchors = document.querySelectorAll('a[href]');
    for (var i = 0; i < anchors.length; i++) {
      var a = anchors[i];
      var href = a.getAttribute('href');
      if (!href) continue;

      if (href === oldDetailsSlug) {
        a.setAttribute('href', inventoryPath);
        continue;
      }

      if (href.indexOf(remoteListingPrefix) === 0) {
        a.setAttribute('href', inventoryPath);
      }
    }

    var a2a = document.querySelectorAll('[data-a2a-url]');
    for (var j = 0; j < a2a.length; j++) {
      var el = a2a[j];
      var url = el.getAttribute('data-a2a-url');
      if (!url) continue;
      if (url === oldDetailsSlug || url.indexOf(remoteListingPrefix) === 0) {
        el.setAttribute('data-a2a-url', inventoryPath);
      }
    }
  }

  function removeCarDetailsSearchResults() {
    var wrap = document.getElementById('elementor-inventory-search-results-25976');
    if (!wrap) return;
    var section = wrap.closest('section');
    if (section) section.remove();
  }

  document.addEventListener(
    'click',
    function (e) {
      if (!document.body.classList.contains('static-mobile-menu-open')) return;
      if (trigger && (e.target === trigger || trigger.contains(e.target))) return;
      if (menu && menu.contains(e.target)) return;
      document.body.classList.remove('static-mobile-menu-open');
      if (trigger) trigger.classList.remove('static-active');
    },
    true
  );

  normalizeListingLinks();
  removeCarDetailsSearchResults();
  initHoverableGalleries();
})();
