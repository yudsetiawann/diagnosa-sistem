<x-guest-layout>
  <!-- Header Section -->
  <div class="mb-8">
    <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">
      Buat Akun Baru
    </h2>
    <p class="mt-2 text-sm text-gray-600">
      Mulai perjalanan anda bersama kami hari ini.
    </p>
  </div>

  <form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    <!-- Name -->
    <div>
      <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-medium" />
      <x-text-input id="name"
        class="block mt-1 w-full rounded-xl border-gray-300 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div>
      <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
      <x-text-input id="email"
        class="block mt-1 w-full rounded-xl border-gray-300 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div>
      <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
      <x-text-input id="password"
        class="block mt-1 w-full rounded-xl border-gray-300 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div>
      <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 font-medium" />
      <x-text-input id="password_confirmation"
        class="block mt-1 w-full rounded-xl border-gray-300 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        type="password" name="password_confirmation" required autocomplete="new-password"
        placeholder="Ulangi password" />
      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- Action Buttons -->
    <div class="pt-2">
      <x-primary-button
        class="w-full justify-center py-3 rounded-xl text-base font-semibold shadow-lg transition duration-200 hover:scale-[1.02]">
        {{ __('Daftar Sekarang') }}
      </x-primary-button>
    </div>

    <div class="flex items-center justify-center mt-6">
      <span class="text-sm text-gray-600">Sudah punya akun?</span>
      <a href="{{ route('login') }}" class="ml-2 text-sm font-bold text-indigo-600 hover:text-indigo-500">
        Masuk di sini
      </a>
    </div>
  </form>
</x-guest-layout>
