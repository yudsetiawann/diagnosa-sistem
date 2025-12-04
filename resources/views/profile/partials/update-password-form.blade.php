<section>
  <header>
    <h2 class="text-xl font-bold text-gray-900">
      {{ __('Update Password') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      {{ __('Pastikan akun anda menggunakan password yang panjang dan acak agar tetap aman.') }}
    </p>
  </header>

  <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('put')

    <div>
      <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" class="font-medium text-gray-700" />
      <x-text-input id="update_password_current_password" name="current_password" type="password"
        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        autocomplete="current-password" placeholder="••••••••" />
      <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="update_password_password" :value="__('Password Baru')" class="font-medium text-gray-700" />
      <x-text-input id="update_password_password" name="password" type="password"
        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        autocomplete="new-password" placeholder="Minimal 8 karakter" />
      <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" class="font-medium text-gray-700" />
      <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        autocomplete="new-password" placeholder="Ulangi password baru" />
      <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4 pt-2">
      <x-primary-button class="rounded-xl px-6 py-2.5 shadow-lg shadow-indigo-500/30">
        {{ __('Update Password') }}
      </x-primary-button>

      @if (session('status') === 'password-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
          class="text-sm text-green-600 font-medium flex items-center">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          {{ __('Berhasil disimpan.') }}
        </p>
      @endif
    </div>
  </form>
</section>
