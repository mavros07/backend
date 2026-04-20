<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-slate-800">{{ __('Users & vendors') }}</h2>
  </x-slot>

  <div class="p-4 sm:p-6 lg:p-8">
    <div class="mx-auto max-w-5xl space-y-8">
      <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-base font-bold text-slate-900">{{ __('Invite or create an account') }}</h3>
        <p class="mt-1 text-sm text-slate-600">{{ __('Choose Admin for full console access, or Vendor for users who only list vehicles.') }}</p>

        <form method="post" action="{{ route('admin.users.store') }}" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-12 lg:items-end">
          @csrf
          <div class="lg:col-span-3">
            <x-input-label for="name" value="{{ __('Name') }}" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
          </div>
          <div class="lg:col-span-3">
            <x-input-label for="email" value="{{ __('Email') }}" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>
          <div class="lg:col-span-2">
            <x-input-label for="password" value="{{ __('Password') }}" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>
          <div class="lg:col-span-2">
            <x-input-label for="password_confirmation" value="{{ __('Confirm') }}" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
          </div>
          <div class="lg:col-span-2">
            <x-input-label for="role" value="{{ __('Role') }}" />
            <select id="role" name="role" class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-amber-500 focus:ring-amber-500">
              <option value="user">{{ __('Vendor (list vehicles)') }}</option>
              <option value="admin">{{ __('Admin (full access)') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
          </div>
          <div class="sm:col-span-2 lg:col-span-12">
            <x-primary-button class="bg-slate-900 hover:bg-slate-800 focus:ring-slate-700">{{ __('Create user') }}</x-primary-button>
          </div>
        </form>
      </div>

      <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
          <h3 class="text-base font-bold text-slate-900">{{ __('All accounts') }}</h3>
          <p class="mt-1 text-sm text-slate-600">{{ __('Admins manage the site; vendors own their listings.') }}</p>
        </div>
        <div class="overflow-x-auto p-4 sm:p-6">
          <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead>
              <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <th class="px-3 py-2">{{ __('Name') }}</th>
                <th class="px-3 py-2">{{ __('Email') }}</th>
                <th class="px-3 py-2">{{ __('Roles') }}</th>
                <th class="px-3 py-2 text-right">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @foreach($users as $user)
                <tr>
                  <td class="px-3 py-3 font-medium text-slate-900">{{ $user->name }}</td>
                  <td class="px-3 py-3 text-slate-600">{{ $user->email }}</td>
                  <td class="px-3 py-3">
                    <div class="flex flex-wrap gap-1">
                      @foreach($user->roles as $role)
                        @if($role->name === 'admin')
                          <span class="inline-flex rounded-full bg-violet-100 px-2.5 py-0.5 text-xs font-semibold text-violet-800">{{ __('Admin') }}</span>
                        @elseif($role->name === 'user')
                          <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-semibold text-sky-800">{{ __('Vendor') }}</span>
                        @else
                          <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs text-slate-700">{{ $role->name }}</span>
                        @endif
                      @endforeach
                    </div>
                  </td>
                  <td class="px-3 py-3 text-right">
                    @if($user->id === auth()->id())
                      <span class="text-xs text-slate-400">{{ __('You') }}</span>
                    @else
                      <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm(@json(__('Delete this user?')));">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-rose-700 hover:underline">{{ __('Delete') }}</button>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="border-t border-slate-100 px-6 py-4">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
