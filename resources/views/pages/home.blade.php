@extends('layouts.site')

@section('content')
  @php
    $body = str_replace('__HOME_INVENTORY_SEARCH__', $homeInventorySearchHtml ?? '', $page->content_html ?? '');
    $recentCarsPattern = '/<div class="elementor-element elementor-element-dac24ce elementor-widget elementor-widget-motors-listings-grid"[^>]*>.*?<\/div>\s*<\/div>\s*<\/div>\s*<\/section>/s';
    $recentCarsReplacement = '<div class="elementor-element elementor-element-dac24ce elementor-widget elementor-widget-motors-listings-grid" data-id="dac24ce" data-element_type="widget" data-widget_type="motors-listings-grid.default"><div class="elementor-widget-container">'.($homeRecentCarsHtml ?? '').'</div></div></div></div></section>';
    $body = preg_replace($recentCarsPattern, $recentCarsReplacement, $body, 1) ?? $body;
  @endphp
  <x-cms.html-block :html="$body" />
@endsection
