<section>
  <header>
    <h2 class="text-xl font-bold text-gray-900">
      {{ __('Informasi Profil & Data Medis') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      {{ __('Lengkapi data diri Anda untuk keperluan rekam medis yang akurat.') }}
    </p>
  </header>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <!-- Nama -->
    <div>
      <x-input-label for="name" :value="__('Nama Lengkap')" class="font-medium text-gray-700 " />
      <x-text-input id="name" name="name" type="text"
        class="mt-2 block w-full rounded-xl border-gray-300  shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        :value="old('name', $user->name)" required autofocus autocomplete="name" />
      <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div>
      <x-input-label for="email" :value="__('Email Address')" class="font-medium text-gray-700" />
      <x-text-input id="email" name="email" type="email"
        class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        :value="old('email', $user->email)" required autocomplete="username" />
      <x-input-error class="mt-2" :messages="$errors->get('email')" />

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div class="mt-2 bg-yellow-50 p-4 rounded-xl border border-yellow-200">
          <p class="text-sm text-yellow-800">
            {{ __('Alamat email anda belum diverifikasi.') }}

            <button form="send-verification"
              class="underline text-sm text-yellow-600  hover:text-yellow-900rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

    <!-- --- DATA MEDIS PASIEN --- -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">

      <!-- Usia -->
      <div>
        <x-input-label for="age" :value="__('Usia (Tahun)')" class="font-medium text-gray-700" />
        <x-text-input id="age" name="age" type="number"
          class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
          :value="old('age', $user->patient->age ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('age')" />
      </div>

      <!-- Gender -->
      <div>
        <x-input-label for="gender" :value="__('Jenis Kelamin')" class="font-medium text-gray-700" />
        <select id="gender" name="gender"
          class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
          <option value="Male" {{ old('gender', $user->patient->gender ?? '') == 'Male' ? 'selected' : '' }}>Laki-laki
          </option>
          <option value="Female" {{ old('gender', $user->patient->gender ?? '') == 'Female' ? 'selected' : '' }}>
            Perempuan</option>
          <option value="Other" {{ old('gender', $user->patient->gender ?? '') == 'Other' ? 'selected' : '' }}>Lainnya
          </option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
      </div>

      <!-- Telepon -->
      <div>
        <x-input-label for="phone" :value="__('Nomor Telepon / WA')" class="font-medium text-gray-700" />
        <x-text-input id="phone" name="phone" type="text"
          class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
          :value="old('phone', $user->patient->phone ?? '')" placeholder="08..." />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
      </div>

      <!-- Alamat -->
      <div>
        <x-input-label for="address" :value="__('Alamat Domisili')" class="font-medium text-gray-700" />
        <x-text-input id="address" name="address" type="text"
          class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
          :value="old('address', $user->patient->address ?? '')" placeholder="Kota / Kabupaten" />
        <x-input-error class="mt-2" :messages="$errors->get('address')" />
      </div>
    </div>

    <div class="flex items-center gap-4 pt-4">
      <x-primary-button class="rounded-xl px-6 py-2.5 shadow-lg shadow-indigo-500/30">
        {{ __('Simpan Perubahan') }}
      </x-primary-button>

      @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
          class="text-sm text-green-600font-medium flex items-center">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          {{ __('Berhasil disimpan.') }}
        </p>
      @endif
    </div>
  </form>
</section>
