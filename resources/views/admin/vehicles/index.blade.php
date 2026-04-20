<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Admin: Vehicles') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-lg bg-white p-5 shadow-sm sm:rounded-lg">
          <div class="text-sm text-gray-500">Total listings</div>
          <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="rounded-lg bg-white p-5 shadow-sm sm:rounded-lg">
          <div class="text-sm text-gray-500">Pending review</div>
          <div class="mt-2 text-2xl font-semibold text-amber-600">{{ $stats['pending'] ?? 0 }}</div>
        </div>
        <div class="rounded-lg bg-white p-5 shadow-sm sm:rounded-lg">
          <div class="text-sm text-gray-500">Approved</div>
          <div class="mt-2 text-2xl font-semibold text-green-600">{{ $stats['approved'] ?? 0 }}</div>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          @if(session('status'))
            <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700">
              {{ session('status') }}
            </div>
          @endif

          @if($vehicles->total() === 0)
            <p>No vehicles.</p>
          @else
            <div class="overflow-x-auto">
              <table class="min-w-full text-sm">
                <thead class="text-left text-gray-500">
                  <tr>
                    <th class="py-2">Title</th>
                    <th class="py-2">Owner</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Submitted</th>
                    <th class="py-2"></th>
                  </tr>
                </thead>
                <tbody class="divide-y">
                  @foreach($vehicles as $vehicle)
                    <tr>
                      <td class="py-2">
                        <div class="font-medium text-gray-900">{{ $vehicle->title }}</div>
                        <div class="text-gray-500">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div>
                      </td>
                      <td class="py-2 text-gray-600">
                        {{ $vehicle->user?->email ?? '' }}
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
                      <td class="py-2 text-gray-500">
                        {{ optional($vehicle->submitted_at)->format('Y-m-d') }}
                      </td>
                      <td class="py-2 text-right space-x-2 whitespace-nowrap">
                        <a class="text-indigo-600 hover:underline" href="{{ route('admin.vehicles.edit', $vehicle) }}">Edit</a>
                        @if($vehicle->status === 'approved')
                          <a class="text-indigo-600 hover:underline" href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}">View</a>
                        @endif
                        <form method="post" action="{{ route('admin.vehicles.approve', $vehicle) }}" class="inline">
                          @csrf
                          <button class="text-green-700 hover:underline" type="submit">Approve</button>
                        </form>
                        <form method="post" action="{{ route('admin.vehicles.reject', $vehicle) }}" class="inline-flex items-center gap-2">
                          @csrf
                          <input
                            type="text"
                            name="rejection_reason"
                            value="{{ $vehicle->rejection_reason }}"
                            placeholder="Reason"
                            class="rounded-md border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          />
                          <button class="text-red-700 hover:underline" type="submit">Reject</button>
                        </form>
                        <form method="post" action="{{ route('admin.vehicles.destroy', $vehicle) }}" class="inline">
                          @csrf
                          @method('DELETE')
                          <button class="text-red-900 hover:underline" type="submit">Delete</button>
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

