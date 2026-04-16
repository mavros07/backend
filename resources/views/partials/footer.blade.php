@php
  $site = $site ?? [];
  $footerAbout = $site['footer_about'] ?? 'Fusce interdum ipsum egestas urna amet fringilla, et placerat ex venenatis. Aliquet luctus pharetra. Proin sed fringilla lectus… ar sit amet tellus in mollis. Proin nec egestas nibh, eget egestas urna. Phasellus sit amet vehicula nunc. In hac habitasse platea dictumst.';
  $copyrightName = $site['copyright_line'] ?? 'MyAutoTorque';
  $socialFacebook = $site['social_facebook'] ?? 'https://www.facebook.com/';
  $socialInstagram = $site['social_instagram'] ?? 'https://www.instagram.com/';
  $socialLinkedin = $site['social_linkedin'] ?? 'https://www.linkedin.com/';
  $socialYoutube = $site['social_youtube'] ?? 'https://www.youtube.com/';
@endphp

<footer id="footer">
  <div id="footer-main">
    <div class="footer_widgets_wrapper more_8">
      <div class="container">
        <div class="widgets cols_4 clearfix">
          <aside class="widget">
            <div class="widget-wrapper">
              <div class="widget-title"><h6>{{ $copyrightName }}</h6></div>
              <div class="textwidget">
                <p>{{ $footerAbout }}</p>
              </div>
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
      </div>
    </div>
  </div>

  <div class="global-alerts"></div>
</footer>

