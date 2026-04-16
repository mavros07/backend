<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Admin: Users') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="font-semibold mb-4">Create user</h3>
          <form method="post" action="{{ route('admin.users.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            <div>
              <x-input-label for="name" value="Name" />
              <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="email" value="Email" />
              <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="password" value="Password" />
              <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="password_confirmation" value="Confirm password" />
              <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div>
              <x-input-label for="role" value="Role" />
              <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="user">user</option>
                <option value="admin">admin</option>
              </select>
              <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
            <div class="md:col-span-2 lg:col-span-3">
              <x-primary-button>Create</x-primary-button>
            </div>
          </form>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="font-semibold mb-4">All users</h3>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="text-left text-gray-500">
                <tr>
                  <th class="py-2">Name</th>
                  <th class="py-2">Email</th>
                  <th class="py-2">Roles</th>
                  <th class="py-2"></th>
                </tr>
              </thead>
              <tbody class="divide-y">
                @foreach($users as $user)
                  <tr>
                    <td class="py-2 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="py-2 text-gray-600">{{ $user->email }}</td>
                    <td class="py-2 text-gray-600">
                      {{ $user->roles->pluck('name')->implode(', ') }}
                    </td>
                    <td class="py-2 text-right">
                      <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="inline">
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
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

