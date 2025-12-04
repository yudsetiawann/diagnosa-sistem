<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
      {{ __('Tambah Penyakit Baru') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
        @include('diseases.form', ['symptoms' => $symptoms])
      </div>
    </div>
  </div>
</x-app-layout>
