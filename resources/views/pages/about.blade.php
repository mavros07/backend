@extends('layouts.site')

@section('content')
  <x-cms.html-block :html="$page->content_html" />
@endsection
