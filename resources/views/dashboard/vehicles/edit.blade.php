<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Vehicle') }}
      </h2>
      @if($vehicle->status === 'approved')
        <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="text-sm text-indigo-600 hover:underline">
          View public page
        </a>
      @endif
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form method="post" action="{{ route('dashboard.vehicles.update', $vehicle) }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
              <x-input-label for="title" value="Title" />
              <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required value="{{ old('title', $vehicle->title) }}" />
              <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="year" value="Year" />
                <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" value="{{ old('year', $vehicle->year) }}" />
                <x-input-error :messages="$errors->get('year')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="price" value="Price" />
                <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" value="{{ old('price', $vehicle->price) }}" />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="make" value="Make" />
                <x-text-input id="make" name="make" type="text" class="mt-1 block w-full" value="{{ old('make', $vehicle->make) }}" />
                <x-input-error :messages="$errors->get('make')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="model" value="Model" />
                <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" value="{{ old('model', $vehicle->model) }}" />
                <x-input-error :messages="$errors->get('model')" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="condition" value="Condition" />
                <select id="condition" name="condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                  <option value="">—</option>
                  <option value="new" @selected(old('condition', $vehicle->condition) === 'new')>New</option>
                  <option value="used" @selected(old('condition', $vehicle->condition) === 'used')>Used</option>
                </select>
                <x-input-error :messages="$errors->get('condition')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="location" value="Location" />
                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" value="{{ old('location', $vehicle->location) }}" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <div>
                <x-input-label for="mileage" value="Mileage" />
                <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" value="{{ old('mileage', $vehicle->mileage) }}" />
                <x-input-error :messages="$errors->get('mileage')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="fuel_type" value="Fuel Type" />
                <x-text-input id="fuel_type" name="fuel_type" type="text" class="mt-1 block w-full" value="{{ old('fuel_type', $vehicle->fuel_type) }}" />
                <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="transmission" value="Transmission" />
                <x-text-input id="transmission" name="transmission" type="text" class="mt-1 block w-full" value="{{ old('transmission', $vehicle->transmission) }}" />
                <x-input-error :messages="$errors->get('transmission')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="body_type" value="Body Type" />
                <x-text-input id="body_type" name="body_type" type="text" class="mt-1 block w-full" value="{{ old('body_type', $vehicle->body_type) }}" />
                <x-input-error :messages="$errors->get('body_type')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="drive" value="Drive" />
                <x-text-input id="drive" name="drive" type="text" class="mt-1 block w-full" value="{{ old('drive', $vehicle->drive) }}" />
                <x-input-error :messages="$errors->get('drive')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="vin" value="VIN" />
                <x-text-input id="vin" name="vin" type="text" class="mt-1 block w-full" value="{{ old('vin', $vehicle->vin) }}" />
                <x-input-error :messages="$errors->get('vin')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="exterior_color" value="Exterior Color" />
                <x-text-input id="exterior_color" name="exterior_color" type="text" class="mt-1 block w-full" value="{{ old('exterior_color', $vehicle->exterior_color) }}" />
                <x-input-error :messages="$errors->get('exterior_color')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="interior_color" value="Interior Color" />
                <x-text-input id="interior_color" name="interior_color" type="text" class="mt-1 block w-full" value="{{ old('interior_color', $vehicle->interior_color) }}" />
                <x-input-error :messages="$errors->get('interior_color')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="engine_size" value="Engine size" />
                <x-text-input id="engine_size" name="engine_size" type="text" class="mt-1 block w-full" value="{{ old('engine_size', $vehicle->engine_size) }}" />
                <x-input-error :messages="$errors->get('engine_size')" class="mt-2" />
              </div>
            </div>

            <div>
              <x-input-label for="features_text" value="Features (one per line)" />
              <textarea id="features_text" name="features_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4">{{ old('features_text', is_array($vehicle->features) ? implode("\n", $vehicle->features) : '') }}</textarea>
              <x-input-error :messages="$errors->get('features_text')" class="mt-2" />
            </div>

            <div>
              <x-input-label for="description" value="Description" />
              <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="5">{{ old('description', $vehicle->description) }}</textarea>
              <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
              <x-input-label for="images" value="Add Gallery Images" />
              <input id="images" name="images[]" type="file" multiple accept=".jpg,.jpeg,.png,.webp" class="mt-1 block w-full text-sm text-gray-700" />
              <p class="mt-1 text-sm text-gray-500">Upload more images here. The first image in the gallery is used as the featured image on inventory cards.</p>
              <x-input-error :messages="$errors->get('images')" class="mt-2" />
              <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
            </div>

            <div class="flex items-center gap-3">
              <x-primary-button>Save</x-primary-button>
              <a href="{{ route('dashboard.vehicles.index') }}" class="text-sm text-gray-600 hover:underline">Back</a>
            </div>
          </form>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          @if(session('status'))
            <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700">
              {{ session('status') }}
            </div>
          @endif

          <h3 class="font-semibold">Gallery</h3>
          <p class="mt-1 text-sm text-gray-600">First image is used as the featured image across the public site.</p>

          @if($vehicle->images->isEmpty())
            <p class="mt-4 text-sm text-gray-500">No images uploaded yet.</p>
          @else
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              @foreach($vehicle->images as $image)
                <div class="rounded-lg border border-gray-200 p-3">
                  <img src="{{ asset($image->path) }}" alt="" class="h-40 w-full rounded-md object-cover" />
                  <div class="mt-3 flex items-center justify-between gap-3">
                    <span class="text-xs font-medium {{ $loop->first ? 'text-indigo-600' : 'text-gray-500' }}">
                      {{ $loop->first ? 'Featured image' : 'Gallery image' }}
                    </span>
                    <form method="post" action="{{ route('dashboard.vehicles.images.destroy', [$vehicle, $image]) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-sm text-red-700 hover:underline">Remove</button>
                    </form>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="flex items-start justify-between gap-4">
            <div>
              <h3 class="font-semibold">Submit for approval</h3>
              <p class="text-sm text-gray-600 mt-1">
                Status: <span class="font-medium">{{ strtoupper($vehicle->status) }}</span>
              </p>
              @if($vehicle->status === 'rejected' && $vehicle->rejection_reason)
                <p class="text-sm text-red-600 mt-2">Reason: {{ $vehicle->rejection_reason }}</p>
              @endif
            </div>
            <form method="post" action="{{ route('dashboard.vehicles.submit', $vehicle) }}">
              @csrf
              <x-primary-button>Submit</x-primary-button>
            </form>
          </div>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="font-semibold text-red-700">Delete listing</h3>
          <p class="mt-1 text-sm text-gray-600">This permanently removes the listing and any linked images.</p>
          <form method="post" action="{{ route('dashboard.vehicles.destroy', $vehicle) }}" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500">
              Delete listing
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

