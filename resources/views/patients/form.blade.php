@php
  $isEdit = isset($patient);
  $actionUrl = $isEdit ? route('patients.update', $patient) : route('patients.store');
@endphp

<form action="{{ $actionUrl }}" method="POST" class="p-8">
  @csrf
  @if ($isEdit)
    @method('PATCH')
  @endif

  <div class="mb-8 border-b border-gray-100 pb-4">
    <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
    <p class="text-sm text-gray-500 mt-1">Lengkapi data diri pasien dengan benar.</p>
  </div>

  <!-- Nama -->
  <div class="mb-6">
    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-medium" />
    <x-text-input id="name" name="name" type="text"
      class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
      :value="old('name', $patient->name ?? '')" placeholder="Masukkan nama lengkap pasien" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Usia -->
    <div>
      <x-input-label for="age" :value="__('Usia (Tahun)')" class="text-gray-700 font-medium" />
      <x-text-input id="age" name="age" type="number"
        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        :value="old('age', $patient->age ?? '')" placeholder="Contoh: 25" required />
      <x-input-error :messages="$errors->get('age')" class="mt-2" />
    </div>

    <!-- Gender -->
    <div>
      <x-input-label for="gender" :value="__('Jenis Kelamin')" class="text-gray-700 font-medium" />
      <select id="gender" name="gender"
        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
        <option value="Male" {{ old('gender', $patient->gender ?? '') == 'Male' ? 'selected' : '' }}>Laki-laki (Male)
        </option>
        <option value="Female" {{ old('gender', $patient->gender ?? '') == 'Female' ? 'selected' : '' }}>Perempuan
          (Female)</option>
        <option value="Other" {{ old('gender', $patient->gender ?? '') == 'Other' ? 'selected' : '' }}>Lainnya</option>
      </select>
      <x-input-error :messages="$errors->get('gender')" class="mt-2" />
    </div>
  </div>

  <!-- Kontak -->
  <div class="mb-6">
    <x-input-label for="phone" :value="__('Nomor Telepon')" class="text-gray-700 font-medium" />
    <div class="relative mt-2 rounded-md shadow-sm">
      <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <span class="text-gray-500 sm:text-sm">📞</span>
      </div>
      <x-text-input id="phone" name="phone" type="text"
        class="block w-full rounded-xl border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
        :value="old('phone', $patient->phone ?? '')" placeholder="0812..." />
    </div>
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
  </div>

  <!-- Alamat -->
  <div class="mb-8">
    <x-input-label for="address" :value="__('Alamat Lengkap')" class="text-gray-700 font-medium" />
    <textarea id="address" name="address" rows="3"
      class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
      placeholder="Masukkan alamat domisili saat ini">{{ old('address', $patient->address ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('address')" class="mt-2" />
  </div>

  <!-- Form Buttons -->
  <div class="flex items-center justify-end pt-6 border-t border-gray-100">
    <a href="{{ route('patients.index') }}"
      class="mr-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
      {{ __('Batal') }}
    </a>

    <x-primary-button class="rounded-xl px-6 py-2.5 shadow-lg shadow-indigo-500/30">
      {{ $isEdit ? __('Update Data') : __('Simpan Pasien') }}
    </x-primary-button>
  </div>
</form>
