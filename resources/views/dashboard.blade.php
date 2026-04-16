<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ Auth::user()->email }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">My listings</div>
                    <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $stats['total'] ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Pending approval</div>
                    <div class="mt-2 text-2xl font-semibold text-amber-600">{{ $stats['pending'] ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Approved listings</div>
                    <div class="mt-2 text-2xl font-semibold text-green-600">{{ $stats['approved'] ?? 0 }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('dashboard.vehicles.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Listings</div>
                    <div class="mt-1 text-lg font-semibold text-gray-900">My Vehicles</div>
                    <div class="mt-3 text-indigo-600 text-sm">Manage listings →</div>
                </a>

                <a href="{{ route('dashboard.vehicles.create') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Create</div>
                    <div class="mt-1 text-lg font-semibold text-gray-900">New Listing</div>
                    <div class="mt-3 text-indigo-600 text-sm">Add a vehicle →</div>
                </a>

                <a href="{{ route('inventory.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <div class="text-sm text-gray-500">Public</div>
                    <div class="mt-1 text-lg font-semibold text-gray-900">Inventory</div>
                    <div class="mt-3 text-indigo-600 text-sm">View website →</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
