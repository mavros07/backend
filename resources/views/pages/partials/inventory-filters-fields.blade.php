@php
  $filters = $filters ?? [];
  $filterOptions = $filterOptions ?? [];
  $submitLabel = $submitLabel ?? 'Apply filters';
  $useSearchIcon = ! empty($useSearchIcon);
@endphp

<div class="row">
  <div class="col-md-3 col-sm-6" style="margin-bottom:12px;">
    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Keyword" />
  </div>
  <div class="col-md-3 col-sm-6" style="margin-bottom:12px;">
    <select name="make" class="form-control">
      <option value="">Any brand</option>
      @foreach(($filterOptions['makes'] ?? collect()) as $make)
        <option value="{{ $make }}" @selected(($filters['make'] ?? '') === $make)>{{ $make }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3 col-sm-6" style="margin-bottom:12px;">
    <select name="model" class="form-control">
      <option value="">Any model</option>
      @foreach(($filterOptions['models'] ?? collect()) as $model)
        <option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3 col-sm-6" style="margin-bottom:12px;">
    <select name="sort" class="form-control">
      <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Newest</option>
      <option value="price_low" @selected(($filters['sort'] ?? '') === 'price_low')>Price: Low to High</option>
      <option value="price_high" @selected(($filters['sort'] ?? '') === 'price_high')>Price: High to Low</option>
      <option value="year_new" @selected(($filters['sort'] ?? '') === 'year_new')>Year: Newest</option>
      <option value="year_old" @selected(($filters['sort'] ?? '') === 'year_old')>Year: Oldest</option>
    </select>
  </div>
</div>
<div class="row">
  <div class="col-md-3 col-sm-6" style="margin-bottom:12px;">
    <select name="condition" class="form-control">
      <option value="">Any condition</option>
      <option value="new" @selected(($filters['condition'] ?? '') === 'new')>New</option>
      <option value="used" @selected(($filters['condition'] ?? '') === 'used')>Used</option>
    </select>
  </div>
  <div class="col-md-3 col-sm-6" style="margin-bottom:12px;">
    <select name="location" class="form-control">
      <option value="">Any location</option>
      @foreach(($filterOptions['locations'] ?? collect()) as $loc)
        <option value="{{ $loc }}" @selected(($filters['location'] ?? '') === $loc)>{{ $loc }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="row">
  <div class="col-md-2 col-sm-6" style="margin-bottom:12px;">
    <input type="number" name="price_min" value="{{ $filters['price_min'] ?? '' }}" class="form-control" placeholder="Min price" />
  </div>
  <div class="col-md-2 col-sm-6" style="margin-bottom:12px;">
    <input type="number" name="price_max" value="{{ $filters['price_max'] ?? '' }}" class="form-control" placeholder="Max price" />
  </div>
  <div class="col-md-2 col-sm-6" style="margin-bottom:12px;">
    <input type="number" name="year_min" value="{{ $filters['year_min'] ?? '' }}" class="form-control" placeholder="Min year" />
  </div>
  <div class="col-md-2 col-sm-6" style="margin-bottom:12px;">
    <input type="number" name="year_max" value="{{ $filters['year_max'] ?? '' }}" class="form-control" placeholder="Max year" />
  </div>
  <div class="col-md-2 col-sm-6" style="margin-bottom:12px;">
    <select name="fuel_type" class="form-control">
      <option value="">Any fuel</option>
      @foreach(($filterOptions['fuel_types'] ?? collect()) as $fuel)
        <option value="{{ $fuel }}" @selected(($filters['fuel_type'] ?? '') === $fuel)>{{ $fuel }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2 col-sm-6" style="margin-bottom:12px;">
    <select name="transmission" class="form-control">
      <option value="">Any transmission</option>
      @foreach(($filterOptions['transmissions'] ?? collect()) as $transmission)
        <option value="{{ $transmission }}" @selected(($filters['transmission'] ?? '') === $transmission)>{{ $transmission }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="row">
  <div class="col-md-3 col-sm-6" style="margin-bottom:12px;">
    <select name="body_type" class="form-control">
      <option value="">Any body type</option>
      @foreach(($filterOptions['body_types'] ?? collect()) as $bodyType)
        <option value="{{ $bodyType }}" @selected(($filters['body_type'] ?? '') === $bodyType)>{{ $bodyType }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-9 col-sm-6" style="display:flex; align-items:center; justify-content:flex-end; gap:10px; flex-wrap:wrap;">
    <a href="{{ route('inventory.index') }}" class="button" style="background:#fff; color:#35475a;">Reset</a>
    @if($useSearchIcon)
      <button type="submit" class="button icon-button">
        <i class="stm-icon-search"></i>{{ $submitLabel }}
      </button>
    @else
      <button type="submit" class="button">{{ $submitLabel }}</button>
    @endif
  </div>
</div>
