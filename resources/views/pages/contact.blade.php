@extends('layouts.site')

@section('content')
  @if(session('status'))
    <div class="container">
      <div style="padding:12px 16px; margin:16px 0; background:var(--motors-success-bg-color,#dbf2a2); border-radius:6px;">
        {{ session('status') }}
      </div>
    </div>
  @endif

  @if($errors->any())
    <div class="container">
      <div style="padding:12px 16px; margin:16px 0; background:var(--motors-error-bg-color); border-radius:6px; color:var(--motors-error-text-color);">
        <ul style="margin:0; padding-left:18px;">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <x-cms.html-block :html="$page->content_html" />

  @include('pages.partials.contact-public-form')

  @include('pages.partials.contact-close-first-section')

  @include('pages.partials.contact-public-tabs-map')

  @include('pages.partials.contact-close-page-inner')
@endsection
