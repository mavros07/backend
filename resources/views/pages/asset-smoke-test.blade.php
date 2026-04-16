<!doctype html>
<html lang="en" class="no-js stm-site-preloader">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Asset smoke test</title>

    <link rel="stylesheet" href="{{ asset('assets/css/vendor-autoptimize.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
  </head>
  <body>
    <div style="padding: 24px; font-family: Arial, sans-serif;">
      <h1 style="margin: 0 0 12px;">Asset smoke test</h1>
      <p style="margin: 0 0 12px;">
        If you can see icon glyphs below (not boxes) and the compare badge style looks correct, CSS + fonts are loading.
      </p>

      <div style="display:flex; gap:16px; align-items:center; flex-wrap:wrap;">
        <span class="list-icon stm-icon-speedometr3" style="font-size: 28px;"></span>
        <span class="list-icon stm-icon-car_search" style="font-size: 28px;"></span>
        <a class="lOffer-compare compare-cta" href="#">
          <span class="heading-font">Compare</span>
          <span class="list-badge">
            <span class="stm-current-cars-in-compare">3</span>
          </span>
        </a>
      </div>
    </div>

    <script src="{{ asset('assets/js/main.js') }}"></script>
  </body>
</html>

