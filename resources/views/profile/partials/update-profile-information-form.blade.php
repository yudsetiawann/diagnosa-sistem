<section>
  <header>
    <h2 class="text-xl font-bold text-gray-900">
      {{ __('Informasi Profil') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      {{ __('Perbarui informasi profil akun dan alamat email anda.') }}
    </p>
  </header>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <div>
      <x-input-label for="name" :value="__('Nama Lengkap')" class="font-medium text-gray-700" />
      <x-text-input id="name" name="name" type="text"
        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        :value="old('name', $user->name)" required autofocus autocomplete="name" />
      <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
      <x-input-label for="email" :value="__('Email Address')" class="font-medium text-gray-700" />
      <x-text-input id="email" name="email" type="email"
        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        :value="old('email', $user->email)" required autocomplete="username" />
      <x-input-error class="mt-2" :messages="$errors->get('email')" />

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div class="mt-2 bg-yellow-50 p-4 rounded-xl border border-yellow-200">
          <p class="text-sm text-yellow-800">
            {{ __('Alamat email anda belum diverifikasi.') }}

            <button form="send-verification"
              class="underline text-sm text-yellow-600 hover:text-yellow-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
            </button>
          </p>

          @if (session('status') === 'verification-link-sent')
            <p class="mt-2 font-medium text-sm text-green-600">
              {{ __('Link verifikasi baru telah dikirim ke email anda.') }}
            </p>
          @endif
        </div>
      @endif
    </div>

    <div class="flex items-center gap-4 pt-2">
      <x-primary-button class="rounded-xl px-6 py-2.5 shadow-lg shadow-indigo-500/30">
        {{ __('Simpan Perubahan') }}
      </x-primary-button>

      @if (session('status') === 'profile-updated')
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
