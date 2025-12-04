<x-guest-layout>
  <!-- Header Section -->
  <div class="mb-8">
    <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">
      Selamat Datang Kembali
    </h2>
    <p class="mt-2 text-sm text-gray-600">
      Silakan masuk ke akun anda untuk melanjutkan.
    </p>
  </div>

  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div>
      <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
      <x-text-input id="email"
        class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
        type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
        placeholder="namakamu@company.com" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div>
      <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />

      <x-text-input id="password"
        class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
        type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me & Forgot Password Wrapper -->
    <div class="flex items-center justify-between">
      <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox"
          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
      </label>

      @if (Route::has('password.request'))
        <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
          {{ __('Lupa password?') }}
        </a>
      @endif
    </div>

    <!-- Submit Button -->
    <div>
      <x-primary-button
        class="w-full justify-center py-3 rounded-xl text-base font-semibold shadow-lg transition duration-200 hover:scale-[1.02]">
        {{ __('Masuk Sekarang') }}
      </x-primary-button>
    </div>

    <!-- Register Link -->
    <div class="relative mt-10">
      <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-200"></div>
      </div>
      <div class="relative flex justify-center text-sm">
        <span class="bg-white px-2 text-gray-500">Belum punya akun?</span>
      </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-3">
      <a href="{{ route('register') }}"
        class="flex w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
        Daftar Akun Baru
      </a>
    </div>
  </form>
</x-guest-layout>
