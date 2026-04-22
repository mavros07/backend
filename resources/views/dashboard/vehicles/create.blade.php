<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('New Vehicle Listing') }}
    </h2>
  </x-slot>

  <div class="w-full">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form method="post" action="{{ route('dashboard.vehicles.store') }}" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <div>
              <x-input-label for="title" value="Title" />
              <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
              <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="year" value="Year" />
                <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('year')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="price" value="Price" />
                <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="make" value="Make" />
                <x-text-input id="make" name="make" type="text" class="mt-1 block w-full" value="{{ old('make') }}" />
                <x-input-error :messages="$errors->get('make')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="model" value="Model" />
                <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" value="{{ old('model') }}" />
                <x-input-error :messages="$errors->get('model')" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="condition" value="Condition" />
                <select id="condition" name="condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                  <option value="">—</option>
                  <option value="new" @selected(old('condition') === 'new')>New</option>
                  <option value="used" @selected(old('condition') === 'used')>Used</option>
                </select>
                <x-input-error :messages="$errors->get('condition')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="location" value="Location" />
                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" placeholder="City, State" value="{{ old('location') }}" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <div>
                <x-input-label for="mileage" value="Mileage" />
                <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" value="{{ old('mileage') }}" />
                <x-input-error :messages="$errors->get('mileage')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="fuel_type" value="Fuel Type" />
                <x-text-input id="fuel_type" name="fuel_type" type="text" class="mt-1 block w-full" value="{{ old('fuel_type') }}" />
                <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="transmission" value="Transmission" />
                <x-text-input id="transmission" name="transmission" type="text" class="mt-1 block w-full" value="{{ old('transmission') }}" />
                <x-input-error :messages="$errors->get('transmission')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="body_type" value="Body Type" />
                <x-text-input id="body_type" name="body_type" type="text" class="mt-1 block w-full" value="{{ old('body_type') }}" />
                <x-input-error :messages="$errors->get('body_type')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="drive" value="Drive" />
                <x-text-input id="drive" name="drive" type="text" class="mt-1 block w-full" value="{{ old('drive') }}" />
                <x-input-error :messages="$errors->get('drive')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="vin" value="VIN" />
                <x-text-input id="vin" name="vin" type="text" class="mt-1 block w-full" value="{{ old('vin') }}" />
                <x-input-error :messages="$errors->get('vin')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="exterior_color" value="Exterior Color" />
                <x-text-input id="exterior_color" name="exterior_color" type="text" class="mt-1 block w-full" value="{{ old('exterior_color') }}" />
                <x-input-error :messages="$errors->get('exterior_color')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="interior_color" value="Interior Color" />
                <x-text-input id="interior_color" name="interior_color" type="text" class="mt-1 block w-full" value="{{ old('interior_color') }}" />
                <x-input-error :messages="$errors->get('interior_color')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="engine_size" value="Engine size" />
                <x-text-input id="engine_size" name="engine_size" type="text" class="mt-1 block w-full" placeholder="e.g. 2.0L turbo" value="{{ old('engine_size') }}" />
                <x-input-error :messages="$errors->get('engine_size')" class="mt-2" />
              </div>
            </div>

            <div>
              <x-input-label for="features_text" value="Features (one per line)" />
              <textarea id="features_text" name="features_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4" placeholder="Leather seats&#10;Sunroof">{{ old('features_text') }}</textarea>
              <x-input-error :messages="$errors->get('features_text')" class="mt-2" />
            </div>

            <div>
              <x-input-label for="description" value="Description" />
              <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="5">{{ old('description') }}</textarea>
              <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
              <x-input-label for="images" value="Gallery Images" />
              <input id="images" name="images[]" type="file" multiple accept=".jpg,.jpeg,.png,.webp" class="mt-1 block w-full text-sm text-gray-700" />
              <p class="mt-1 text-sm text-gray-500">Upload up to 12 JPG, PNG, or WebP images. The first uploaded image becomes the featured image.</p>
              <x-input-error :messages="$errors->get('images')" class="mt-2" />
              <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
            </div>

            <div class="flex items-center gap-3">
              <x-primary-button>Create</x-primary-button>
              <a href="{{ route('dashboard.vehicles.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
            </div>
          </form>
        </div>
      </div>
  </div>
</x-app-layout>

