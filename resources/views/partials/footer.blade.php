@php
  $site = $site ?? [];
  $footerAbout = $site['footer_about'] ?? 'Fusce interdum ipsum egestas urna amet fringilla, et placerat ex venenatis. Aliquet luctus pharetra. Proin sed fringilla lectus... ar sit amet tellus in mollis. Proin nec egestas nibh, eget egestas urna. Phasellus sit amet vehicula nunc. In hac habitasse platea dictumst.';
  $copyrightName = $site['copyright_line'] ?? 'MyAutoTorque';
  $dealerPhone = $site['dealer_phone'] ?? '+1 212-226-3126';
  $dealerSalesPhone = $site['dealer_sales_phone'] ?? '(888) 354-1781';
  $dealerSalesHours = preg_split('/\r\n|\r|\n/', $site['dealer_sales_hours'] ?? "Monday - Friday: 09:00AM - 09:00PM\nSaturday: 09:00AM - 07:00PM\nSunday: Closed") ?: [];
  $socialFacebook = $site['social_facebook'] ?? 'https://www.facebook.com/';
  $socialInstagram = $site['social_instagram'] ?? 'https://www.instagram.com/';
  $socialLinkedin = $site['social_linkedin'] ?? 'https://www.linkedin.com/';
  $socialYoutube = $site['social_youtube'] ?? 'https://www.youtube.com/';
  $footerGallery = [
    'assets/images/wp-uploads/sites/24/2022/09/nissan_altima_1-300x189-1.jpg',
    'assets/images/wp-uploads/sites/24/2021/05/motor-1-795x463-1.jpg',
    'assets/images/wp-uploads/sites/24/2021/05/4-1109x699-1.jpg',
    'assets/images/wp-uploads/sites/24/2022/10/post_id_2027_srDqt-999x719-1.jpg',
  ];
  $footerPosts = [
    [
      'title' => 'The Tesla Model S is not the first truly autonomous car on the road...',
      'url' => route('inventory.index'),
      'comments_label' => 'No comments',
    ],
    [
      'title' => 'How to compare trims, mileage, and value before you buy.',
      'url' => route('faq'),
      'comments_label' => 'Buying guide',
    ],
  ];
@endphp

<footer id="footer">
  <div id="footer-main">
    <div class="footer_widgets_wrapper more_8">
      <div class="container">
        <div class="widgets cols_4 clearfix">
          <aside class="widget stm_wp_widget_text">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>{{ $copyrightName }}</h6></div>
              <div class="textwidget">
                <p>{{ $footerAbout }}</p>
              </div>
            </div>
          </aside>

          <aside class="widget widget_block">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>Photo gallery</h6></div>
              <div class="wp-widget-group__inner-blocks">
                <figure class="wp-block-gallery has-nested-images columns-4 is-cropped wp-block-gallery-2 is-layout-flex wp-block-gallery-is-layout-flex">
                  @foreach ($footerGallery as $galleryImage)
                    <figure class="wp-block-image size-thumbnail">
                      <img src="{{ asset($galleryImage) }}" alt="Gallery image" loading="lazy" decoding="async" />
                    </figure>
                  @endforeach
                </figure>
              </div>
            </div>
          </aside>

          <aside class="widget stm_widget_recent_entries">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>Latest Blog posts</h6></div>
              @foreach ($footerPosts as $post)
                <div class="stm-last-post-widget">
                  {{ $post['title'] }}
                  <div class="comments-number">
                    <a href="{{ $post['url'] }}"><i class="stm-icon-message"></i>{{ $post['comments_label'] }}</a>
                  </div>
                </div>
              @endforeach
            </div>
          </aside>

          <aside class="widget widget_socials">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>Social Network</h6></div>
              <div class="socials_widget_wrapper">
                <ul class="widget_socials list-unstyled clearfix">
                  <li>
                    <a href="{{ $socialFacebook }}" target="_blank" rel="noreferrer"><i class="fab fa-facebook"></i></a>
                  </li>
                  <li>
                    <a href="{{ $socialInstagram }}" target="_blank" rel="noreferrer"><i class="fab fa-instagram"></i></a>
                  </li>
                  <li>
                    <a href="{{ $socialLinkedin }}" target="_blank" rel="noreferrer"><i class="fab fa-linkedin"></i></a>
                  </li>
                  <li>
                    <a href="{{ $socialYoutube }}" target="_blank" rel="noreferrer"><i class="fab fa-youtube"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </aside>

          <aside class="widget widget_mc4wp_form_widget">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>Subscribe</h6></div>
              <form action="{{ route('contact') }}" method="get">
                <div class="mc4wp-form-fields">
                  <div class="stm-mc-unit">
                    <input type="email" name="email" placeholder="Enter your email..." />
                    <input type="submit" value="Sign up" />
                  </div>
                  <div class="stm-mc-label">Get latest updates and offers.</div>
                </div>
              </form>
            </div>
          </aside>

          <aside class="widget widget_text">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>Sales Hours</h6></div>
              <div class="textwidget">
                <p>
                  @foreach ($dealerSalesHours as $line)
                    @php
                      [$label, $value] = array_pad(explode(':', $line, 2), 2, '');
                    @endphp
                    <span class="date">{{ trim($label) }}:</span> {{ trim($value) }}<br />
                  @endforeach
                  <span class="date">Sales:</span> {{ $dealerSalesPhone }}<br />
                  <span class="date">Main:</span> {{ $dealerPhone }}
                </p>
              </div>
            </div>
          </aside>

          <aside class="widget widget_text">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>Service Hours</h6></div>
              <div class="textwidget">
                <p>
                  @foreach ($dealerSalesHours as $line)
                    @php
                      [$label, $value] = array_pad(explode(':', $line, 2), 2, '');
                    @endphp
                    <span class="date">{{ trim($label) }}:</span> {{ trim($value) }}<br />
                  @endforeach
                </p>
              </div>
            </div>
          </aside>

          <aside class="widget widget_text">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>Parts Hours</h6></div>
              <div class="textwidget">
                <p>
                  @foreach ($dealerSalesHours as $line)
                    @php
                      [$label, $value] = array_pad(explode(':', $line, 2), 2, '');
                    @endphp
                    <span class="date">{{ trim($label) }}:</span> {{ trim($value) }}<br />
                  @endforeach
                </p>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </div>

  <div id="footer-copyright" style="background-color:#232628">
    <div class="container footer-copyright">
      <div class="row">
        <div class="col-md-8 col-sm-8">
          <div class="clearfix">
            <div class="copyright-text heading-font">
              Copyright © {{ date('Y') }}. {{ $copyrightName }}
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-4">
          <div class="clearfix">
            <div class="pull-right xs-pull-left">
              <div class="pull-right">
                <div class="copyright-socials">
                  <ul class="clearfix">
                    <li>
                      <a href="{{ $socialFacebook }}" target="_blank" rel="noreferrer">
                        <i class="fab fa-facebook"></i>
                      </a>
                    </li>
                    <li>
                      <a href="{{ $socialInstagram }}" target="_blank" rel="noreferrer">
                        <i class="fab fa-instagram"></i>
                      </a>
                    </li>
                    <li>
                      <a href="{{ $socialLinkedin }}" target="_blank" rel="noreferrer">
                        <i class="fab fa-linkedin"></i>
                      </a>
                    </li>
                    <li>
                      <a href="{{ $socialYoutube }}" target="_blank" rel="noreferrer">
                        <i class="fab fa-youtube-play"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="global-alerts"></div>
</footer>

