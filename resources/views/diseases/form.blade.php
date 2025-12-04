@php
  $isEdit = isset($disease);
  $actionUrl = $isEdit ? route('diseases.update', $disease) : route('diseases.store');

  // Ambil ID gejala yang sudah ter-attach (jika edit)
  $attachedSymptomIds = $isEdit ? $disease->symptoms->pluck('id')->toArray() : [];
@endphp

<form action="{{ $actionUrl }}" method="POST" class="p-8">
  @csrf
  @if ($isEdit)
    @method('PATCH')
  @endif

  <div class="mb-8 border-b border-gray-100 pb-4">
    <h3 class="text-lg font-bold text-gray-900">Detail Penyakit</h3>
    <p class="text-sm text-gray-500 mt-1">Masukkan informasi penyakit dan gejala yang berkaitan.</p>
  </div>

  <!-- Nama Penyakit -->
  <div class="mb-6">
    <x-input-label for="name" :value="__('Nama Penyakit')" class="text-gray-700 font-medium" />
    <x-text-input id="name" name="name" type="text"
      class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 py-2.5"
      :value="old('name', $disease->name ?? '')" placeholder="Contoh: Influenza" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
  </div>

  <!-- Deskripsi -->
  <div class="mb-6">
    <x-input-label for="description" :value="__('Deskripsi / Solusi')" class="text-gray-700 font-medium" />
    <textarea id="description" name="description" rows="4"
      class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
      placeholder="Jelaskan detail penyakit atau solusi penanganan...">{{ old('description', $disease->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
  </div>

  <!-- Gejala Terkait (Multiple Select) -->
  <div class="mb-8">
    <x-input-label for="symptoms" :value="__('Gejala Terkait')" class="text-gray-700 font-medium" />
    <div class="mt-2 relative">
      <select id="symptoms" name="symptoms[]" multiple
        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 min-h-[200px] text-sm">
        @foreach ($symptoms as $symptom)
          <option value="{{ $symptom->id }}"
            class="p-2 border-b border-gray-50 hover:bg-rose-50 cursor-pointer checked:bg-rose-100 checked:text-rose-800"
            @if (in_array($symptom->id, old('symptoms', $attachedSymptomIds))) selected @endif>
            {{ $symptom->name }}
          </option>
        @endforeach
      </select>
      <p class="mt-2 text-xs text-gray-500 flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Tips: Tahan tombol <strong class="mx-1">Ctrl</strong> (Windows) atau <strong class="mx-1">Command</strong>
        (Mac) untuk memilih lebih dari satu gejala.
      </p>
    </div>
    <x-input-error :messages="$errors->get('symptoms')" class="mt-2" />
  </div>

  <!-- Form Buttons -->
  <div class="flex items-center justify-end pt-6 border-t border-gray-100">
    <a href="{{ route('diseases.index') }}"
      class="mr-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
      {{ __('Batal') }}
    </a>

    <x-primary-button
      class="bg-rose-600 hover:bg-rose-700 active:bg-rose-800 focus:ring-rose-500 rounded-xl px-6 py-2.5 shadow-lg shadow-rose-500/30">
      {{ $isEdit ? __('Update Penyakit') : __('Simpan Penyakit') }}
    </x-primary-button>
  </div>
</form>
