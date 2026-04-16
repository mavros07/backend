@php
  $site = $site ?? [];
  $address = $site['dealer_address'] ?? '';
  $salesPhone = $site['dealer_sales_phone'] ?? '';
  $hours = $site['dealer_sales_hours'] ?? '';
@endphp

<section
  class="elementor-section elementor-top-section elementor-element elementor-element-f3fe490 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
  data-element_type="section"
>
  <div class="elementor-container elementor-column-gap-default">
    <div
      class="elementor-column elementor-col-33 elementor-top-column elementor-element"
      data-element_type="column"
    >
      <div class="elementor-widget-wrap elementor-element-populated">
        <div class="elementor-element elementor-widget elementor-widget-motors-contact-tabs" data-widget_type="motors-contact-tabs.default">
          <div class="elementor-widget-container">
            <div class="stm-elementor-contact-tabs">
              <div class="elementor-contact-tabs">
                <div class="elementor-contact-tabs-container">
                  <ul class="elementor-contact-tabs-list">
                    <li class="elementor-contact-tab active" data-tab="parts">
                      <span class="tab-item">
                        <span class="elementor-contact-title-text">Parts</span>
                      </span>
                    </li>
                    <li class="elementor-contact-tab" data-tab="sales">
                      <span class="tab-item">
                        <span class="elementor-contact-title-text">Sales</span>
                      </span>
                    </li>
                    <li class="elementor-contact-tab" data-tab="renting">
                      <span class="tab-item">
                        <span class="elementor-contact-title-text">Renting</span>
                      </span>
                    </li>
                  </ul>
                </div>
                <div class="contact-tabs-containers-wrap">
                  <div class="elementor-contact-panels-container contact-panel-parts active">
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-pin"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Address</h4>
                        <div class="content heading-font">
                          <p>{{ $address }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-phone"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Sales Phone</h4>
                        <div class="content heading-font">
                          <p>{{ $salesPhone }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-time"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Sales Hours</h4>
                        <div class="content heading-font">
                          {!! nl2br(e($hours)) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="elementor-contact-panels-container contact-panel-sales" style="display:none;">
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-pin"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Address</h4>
                        <div class="content heading-font">
                          <p>{{ $address }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-phone"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Sales Phone</h4>
                        <div class="content heading-font">
                          <p>{{ $salesPhone }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-time"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Sales Hours</h4>
                        <div class="content heading-font">
                          {!! nl2br(e($hours)) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="elementor-contact-panels-container contact-panel-renting" style="display:none;">
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-pin"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Address</h4>
                        <div class="content heading-font">
                          <p>{{ $address }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-phone"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Sales Phone</h4>
                        <div class="content heading-font">
                          <p>{{ $salesPhone }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="tab-unit">
                      <div class="icon">
                        <i class="stmicon- stm-icon-time"></i>
                      </div>
                      <div class="text">
                        <h4 class="title heading-font">Sales Hours</h4>
                        <div class="content heading-font">
                          {!! nl2br(e($hours)) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="elementor-column elementor-col-66 elementor-top-column elementor-element" data-element_type="column">
      <div class="elementor-widget-wrap elementor-element-populated">
        <div class="elementor-element elementor-widget elementor-widget-stm-google-map" data-widget_type="stm-google-map.default">
          <div class="elementor-widget-container">
            <div id="stm_map_contact_embed" class="stm-elementor-google-map" style="min-height: 420px;">
              @if($address !== '')
                <iframe
                  title="Dealer location"
                  loading="lazy"
                  style="width: 100%; height: 420px; border: 0;"
                  src="https://www.google.com/maps?q={{ urlencode($address) }}&output=embed"
                  allowfullscreen
                ></iframe>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
  <script>
    (function () {
      var tabs = document.querySelectorAll('.elementor-contact-tab');
      var panels = {
        parts: document.querySelector('.contact-panel-parts'),
        sales: document.querySelector('.contact-panel-sales'),
        renting: document.querySelector('.contact-panel-renting'),
      };
      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          var id = tab.getAttribute('data-tab');
          tabs.forEach(function (t) {
            t.classList.remove('active');
          });
          tab.classList.add('active');
          Object.keys(panels).forEach(function (key) {
            var el = panels[key];
            if (!el) {
              return;
            }
            var on = key === id;
            el.style.display = on ? 'block' : 'none';
            el.classList.toggle('active', on);
          });
        });
      });
    })();
  </script>
@endpush
