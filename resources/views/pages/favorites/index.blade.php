@extends('layouts.site')

@section('content')
  <div class="container">
    <div style="margin: 24px 0 16px;">
      <h1 class="heading-font" style="margin: 0;">Saved listings</h1>
      <p class="text-muted" style="margin: 8px 0 0;">Vehicles you bookmarked from inventory.</p>
    </div>

    @if (session('status'))
      <div style="padding:12px 16px;margin-bottom:16px;background:var(--site-success-bg,#dbf2a2);border-radius:8px;">
        {{ session('status') }}
      </div>
    @endif

    <div class="inv-results" id="listings-result">
      @forelse($vehicles as $vehicle)
        @php
          $images = $vehicle->images ?? collect();
          $hover = $images->slice(0, 5);
        @endphp

        <article class="inv-card">
          <div class="inv-card__media">
            <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}">
              <div class="interactive-hoverable">
                <span class="inv-card__badge">Saved</span>
                <div class="hoverable-wrap">
                  @forelse($hover as $idx => $img)
                    <div class="hoverable-unit {{ $idx === 0 ? 'active' : '' }}">
                      <div class="thumb">
                        <img
                          loading="lazy"
                          decoding="async"
                          src="{{ \App\Support\VehicleImageUrl::url($img->path) }}"
                          alt="{{ $vehicle->title }}"
                        />
                      </div>
                    </div>
                  @empty
                    <div class="hoverable-unit active">
                      <div class="thumb" style="display:flex;align-items:center;justify-content:center;background:#f0f3f7;min-height:220px;">
                        <span class="heading-font text-muted">No image</span>
                      </div>
                    </div>
                  @endforelse
                </div>

                @if($hover->isNotEmpty())
                  <div class="hoverable-indicators">
                    @foreach($hover as $idx => $img)
                      <div class="indicator {{ $idx === 0 ? 'active' : '' }}"></div>
                    @endforeach
                  </div>
                @endif
              </div>
            </a>
          </div>

          <div class="inv-card__body">
            <div class="inv-card__price-row">
              <span class="inv-card__eyebrow">Buy online</span>
              <span class="inv-card__price">
                @if(!is_null($vehicle->price))
                  <span data-currency-amount="{{ (float) $vehicle->price }}" data-currency-decimals="0">${{ number_format($vehicle->price, 0, '.', ' ') }}</span>
                @endif
              </span>
            </div>
            <h2 class="inv-card__title">
              <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}">
                <span class="text-muted" style="font-size: 14px; font-weight: 600;">{{ $vehicle->model ?? '' }}</span>
                {{ $vehicle->year ?? '' }}
              </a>
            </h2>

            <div class="inv-card__meta">
              <div class="inv-card__meta-item">
                <span class="label">Mileage</span>
                <span class="value">{{ $vehicle->mileage ?? '' }} mi</span>
              </div>
              <div class="inv-card__meta-item">
                <span class="label">Fuel</span>
                <span class="value">{{ $vehicle->fuel_type ?? '' }}</span>
              </div>
              <div class="inv-card__meta-item">
                <span class="label">Transmission</span>
                <span class="value">{{ $vehicle->transmission ?? '' }}</span>
              </div>
            </div>

            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
              <form method="post" action="{{ route('compare.add', ['vehicle' => $vehicle->id]) }}">
                @csrf
                <button type="submit" class="btn btn--primary">Add to compare</button>
              </form>
              <form method="post" action="{{ route('favorites.toggle', ['vehicle' => $vehicle->id]) }}">
                @csrf
                <button type="submit" class="btn btn--outline">Remove</button>
              </form>
            </div>
          </div>
        </article>
      @empty
        <div class="inv-empty">
          <p>No saved vehicles yet.</p>
          <a class="btn btn--primary" href="{{ route('inventory.index') }}" style="margin-top: 12px; display: inline-block;">Browse inventory</a>
        </div>
      @endforelse
    </div>

    @if($vehicles->hasPages())
      <div style="margin: 24px 0 40px;">
        {{ $vehicles->links() }}
      </div>
    @endif
  </div>
@endsection
