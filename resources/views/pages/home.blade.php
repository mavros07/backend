@extends('layouts.site')

@section('content')
  @php
    $body = str_replace('__HOME_INVENTORY_SEARCH__', $homeInventorySearchHtml ?? '', $page->content_html ?? '');
  @endphp
  <x-cms.html-block :html="$body" />
@endsection
