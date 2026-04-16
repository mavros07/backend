<x-guest-layout>
  <div class="mb-4 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/40 dark:bg-amber-950/30 dark:text-amber-100">
    <strong>Temporary page.</strong> Creates the <strong>first</strong> admin (Spatie role <code class="rounded bg-black/10 px-1">admin</code>).
    After use: set <code class="rounded bg-black/10 px-1">ADMIN_BOOTSTRAP_ENABLED=false</code> in <code class="rounded bg-black/10 px-1">.env</code> and remove the bootstrap routes from <code class="rounded bg-black/10 px-1">routes/web.php</code>.
  </div>

  @if($blocked ?? false)
    <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-900/40 dark:bg-red-950/30 dark:text-red-200">
      <p class="font-semibold">An admin already exists — this page is blocked.</p>
      @if(($admins ?? collect())->isNotEmpty())
        <ul class="mt-2 list-disc pl-5">
          @foreach($admins as $a)
            <li>{{ $a->email }} @if($a->name) ({{ $a->name }}) @endif</li>
          @endforeach
        </ul>
      @endif
      <p class="mt-3 text-xs opacity-90">
        To create a new first admin, remove the admin role from existing users in the database, or delete this user and clear related
        <code class="rounded bg-black/10 px-1">model_has_roles</code> rows, then refresh this page.
      </p>
    </div>
  @else
    <form method="POST" action="{{ route('bootstrap.admin.store') }}">
      @csrf

      <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm password')" />
        <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
      </div>

      <div class="mt-6 flex items-center justify-end">
        <x-primary-button>{{ __('Create admin') }}</x-primary-button>
      </div>
    </form>
  @endif
</x-guest-layout>
