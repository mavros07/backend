<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-4">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('My Vehicles') }}
      </h2>
      <a
        href="{{ route('dashboard.vehicles.create') }}"
        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
      >
        New listing
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          @if(session('status'))
            <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700">
              {{ session('status') }}
            </div>
          @endif

          @if($vehicles->total() === 0)
            <p>You have no listings yet.</p>
          @else
            <div class="overflow-x-auto">
              <table class="min-w-full text-sm">
                <thead class="text-left text-gray-500">
                  <tr>
                    <th class="py-2">Title</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Created</th>
                    <th class="py-2 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y">
                  @foreach($vehicles as $vehicle)
                    <tr>
                      <td class="py-2">
                        <div class="font-medium text-gray-900">{{ $vehicle->title }}</div>
                        <div class="text-gray-500">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div>
                      </td>
                      <td class="py-2">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                          @if($vehicle->status === 'approved') bg-green-100 text-green-800
                          @elseif($vehicle->status === 'pending') bg-yellow-100 text-yellow-800
                          @elseif($vehicle->status === 'rejected') bg-red-100 text-red-800
                          @else bg-gray-100 text-gray-800
                          @endif
                        ">
                          {{ strtoupper($vehicle->status) }}
                        </span>
                      </td>
                      <td class="py-2 text-gray-500">{{ $vehicle->created_at->format('Y-m-d') }}</td>
                      <td class="py-2 text-right space-x-3 whitespace-nowrap">
                        @if($vehicle->status === 'approved')
                          <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="text-gray-600 hover:underline">View</a>
                        @endif
                        <a href="{{ route('dashboard.vehicles.edit', $vehicle) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="post" action="{{ route('dashboard.vehicles.destroy', $vehicle) }}" class="inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-700 hover:underline">Delete</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="mt-4">
              {{ $vehicles->links() }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

