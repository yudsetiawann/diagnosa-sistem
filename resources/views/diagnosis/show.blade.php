<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      Detail Informasi Penyakit
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">

        <!-- Header Penyakit -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-8 text-white">
          <div class="flex items-center mb-2">
            <span class="bg-white/20 text-white text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">
              Ensiklopedia Medis
            </span>
          </div>
          <h1 class="text-4xl font-extrabold mb-2">{{ $disease->name }}</h1>
        </div>

        <div class="p-8">
          <!-- Deskripsi -->
          <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Deskripsi Penyakit
            </h3>
            <p class="text-gray-700 text-lg leading-relaxed">
              {{ $disease->description }}
            </p>
          </div>

          <!-- Gejala Umum -->
          <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                </path>
              </svg>
              Gejala Umum
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              @foreach ($disease->symptoms as $symptom)
                <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                  <svg class="w-5 h-5 text-indigo-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <div>
                    <span class="font-semibold text-gray-800">{{ $symptom->name }}</span>
                    @if ($symptom->description)
                      <p class="text-sm text-gray-500 mt-1">{{ $symptom->description }}</p>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Disclaimer -->
          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  Informasi ini hanya untuk tujuan edukasi. Jangan gunakan untuk pengobatan mandiri tanpa berkonsultasi
                  dengan dokter profesional.
                </p>
              </div>
            </div>
          </div>

          <!-- Tombol Kembali -->
          <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
            <a href="javascript:history.back()"
              class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150">
              &larr; Kembali
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
