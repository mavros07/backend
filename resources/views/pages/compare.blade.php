@extends('layouts.site')

@section('content')
  <div class="container" style="padding: 24px 0;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap: 12px; flex-wrap:wrap;">
      <h1 class="heading-font" style="margin:0;">Compare</h1>
      <form method="post" action="{{ route('compare.clear') }}">
        @csrf
        <button type="submit" class="button">Clear</button>
      </form>
    </div>

    @if(($vehicles ?? collect())->isEmpty())
      <div class="stm-listings-empty" style="margin-top: 20px;">
        <span class="stm-listings-empty__not-found">No vehicles in compare.</span>
      </div>
    @else
      <div class="row" style="margin-top: 20px;">
        @foreach($vehicles as $vehicle)
          @php $img = ($vehicle->images ?? collect())->first(); @endphp
          <div class="col-md-4 col-sm-6" style="margin-bottom: 18px;">
            <div class="listing-list-loop stm-listing-directory-list-loop listing_is_active">
              <div class="image">
                <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="rmv_txt_drctn">
                  @if($img?->path)
                    <img
                      class="img-responsive"
                      src="{{ asset($img->path) }}"
                      alt="{{ $vehicle->title }}"
                    />
                  @else
                    <div class="img-responsive" style="width:100%; aspect-ratio: 795 / 463; background: #f0f3f7; display:flex; align-items:center; justify-content:center;">
                      <span class="heading-font" style="opacity:.7;">No image</span>
                    </div>
                  @endif
                </a>
              </div>
              <div class="content" style="padding: 12px;">
                <div class="title heading-font" style="margin-bottom: 6px;">
                  <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="rmv_txt_drctn">
                    {{ $vehicle->title }}
                  </a>
                </div>
                <div class="heading-font" style="margin-bottom: 10px;">
                  @if(!is_null($vehicle->price))
                    ${{ number_format($vehicle->price, 0, '.', ' ') }}
                  @endif
                </div>
                <div style="display:flex; gap: 10px; flex-wrap:wrap; font-size: 13px;">
                  <span><strong>Mileage:</strong> {{ $vehicle->mileage ?? '' }}</span>
                  <span><strong>Fuel:</strong> {{ $vehicle->fuel_type ?? '' }}</span>
                  <span><strong>Trans:</strong> {{ $vehicle->transmission ?? '' }}</span>
                </div>

                <form method="post" action="{{ route('compare.remove', ['vehicle' => $vehicle->id]) }}" style="margin-top: 12px;">
                  @csrf
                  <button type="submit" class="button">Remove</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection

