<form method="post" action="{{ route('contact.submit') }}" class="wpcf7-form init" novalidate>
  @csrf

  <div class="row">
    <div class="col-md-7 col-sm-7">
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <div class="contact-us-label">First Name*</div>
            <input
              type="text"
              name="first_name"
              class="wpcf7-form-control wpcf7-text"
              placeholder="Enter your first name"
              value="{{ old('first_name') }}"
              required
            />
            @error('first_name')
              <div style="color:#c00; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <div class="contact-us-label">Last Name*</div>
            <input
              type="text"
              name="last_name"
              class="wpcf7-form-control wpcf7-text"
              placeholder="Enter your last name"
              value="{{ old('last_name') }}"
              required
            />
            @error('last_name')
              <div style="color:#c00; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <div class="contact-us-label">Email*</div>
            <input
              type="email"
              name="email"
              class="wpcf7-form-control wpcf7-email"
              placeholder="email@domain.com"
              value="{{ old('email') }}"
              required
            />
            @error('email')
              <div style="color:#c00; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <div class="contact-us-label">Phone</div>
            <input
              type="tel"
              name="phone"
              class="wpcf7-form-control wpcf7-tel"
              placeholder="Phone number"
              value="{{ old('phone') }}"
            />
            @error('phone')
              <div style="color:#c00; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-5 col-sm-5">
      <div class="form-group">
        <div class="form-group">
          <div class="contact-us-label">Comment</div>
          <textarea
            name="message"
            cols="40"
            rows="10"
            class="wpcf7-form-control wpcf7-textarea"
            placeholder="Enter your message..."
            required
          >{{ old('message') }}</textarea>
          @error('message')
            <div style="color:#c00; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="contact-us-submit">
        <input class="wpcf7-form-control wpcf7-submit has-spinner contact-us-submit" type="submit" value="Submit" />
      </div>
    </div>
  </div>

  <div class="wpcf7-response-output" aria-hidden="true"></div>
</form>
