@php
  // Cek apakah ini mode 'edit' (ada $symptom) atau 'create'
  $isEdit = isset($symptom);

  // Tentukan URL action form
  $actionUrl = $isEdit ? route('symptoms.update', $symptom) : route('symptoms.store');
@endphp

<form action="{{ $actionUrl }}" method="POST" class="p-8">
  @csrf

  @if ($isEdit)
    @method('PATCH')
  @endif

  <div class="mb-8 border-b border-gray-100 pb-4">
    <h3 class="text-lg font-bold text-gray-900">Informasi Gejala</h3>
    <p class="text-sm text-gray-500 mt-1">Masukkan nama gejala dan deskripsi detailnya.</p>
  </div>

  <!-- Nama Gejala -->
  <div class="mb-6">
    <x-input-label for="name" :value="__('Nama Gejala')" class="text-gray-700 font-medium" />
    <x-text-input id="name" name="name" type="text"
      class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-2.5"
      :value="old('name', $symptom->name ?? '')" placeholder="Contoh: Demam Tinggi, Mual" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
  </div>

  <!-- Deskripsi -->
  <div class="mb-8">
    <x-input-label for="description" :value="__('Deskripsi')" class="text-gray-700 font-medium" />
    <textarea id="description" name="description" rows="4"
      class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
      placeholder="Jelaskan karakteristik gejala ini...">{{ old('description', $symptom->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
  </div>

  <!-- Form Buttons -->
  <div class="flex items-center justify-end pt-6 border-t border-gray-100">
    <a href="{{ route('symptoms.index') }}"
      class="mr-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
      {{ __('Batal') }}
    </a>

    <x-primary-button
      class="bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 focus:ring-emerald-500 rounded-xl px-6 py-2.5 shadow-lg shadow-emerald-500/30">
      {{ $isEdit ? __('Update Gejala') : __('Simpan Gejala') }}
    </x-primary-button>
  </div>
</form>
