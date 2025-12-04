<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
      {{ __('Pencarian Pintar') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <!-- Hero Search Section -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 text-center">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Cari Penyakit Berdasarkan Gejala</h3>
        <p class="text-gray-500 mb-8 max-w-2xl mx-auto">Masukkan kata kunci gejala yang dirasakan (contoh: "Demam",
          "Mual", "Pusing") untuk menemukan penyakit yang relevan.</p>

        <form method="GET" action="{{ route('diagnosis.search') }}" class="max-w-xl mx-auto relative">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <input type="text" name="symptom_name"
              class="block w-full pl-12 pr-4 py-4 bg-gray-50 border-gray-200 rounded-full text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all text-lg"
              placeholder="Ketik gejala disini..." value="{{ $searchTerm ?? old('symptom_name') }}" required autofocus>
            <button type="submit"
              class="absolute right-2 top-2 bottom-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 rounded-full font-semibold transition-colors shadow-md">
              Cari
            </button>
          </div>
        </form>
      </div>

      <!-- Results Section -->
      @if (isset($results))
        <div class="mb-4 flex items-center justify-between">
          <h4 class="text-lg font-bold text-gray-800">
            Hasil Pencarian:
            <span class="text-indigo-600 ml-1">"{{ $searchTerm }}"</span>
          </h4>
          <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100">
            {{ $results->count() }} hasil ditemukan
          </span>
        </div>

        @if ($results->isEmpty())
          <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="bg-gray-50 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4">
              <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-500 mt-2">Coba gunakan kata kunci gejala yang lebih umum.</p>
          </div>
        @else
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($results as $disease)
              <div
                class="group bg-white rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full">
                <div class="p-6 flex-1">
                  <div class="flex items-start justify-between mb-4">
                    <div
                      class="p-3 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                      </svg>
                    </div>
                  </div>

                  <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                    {{ $disease->name }}
                  </h4>
                  <p class="text-sm text-gray-500 line-clamp-3 mb-6">
                    {{ $disease->description }}
                  </p>

                  <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Gejala Terkait</p>
                    <div class="flex flex-wrap gap-2">
                      @foreach ($disease->symptoms as $symptom)
                        @php
                          // Highlight jika gejala ini mengandung kata kunci pencarian
                          $isMatch = stripos($symptom->name, $searchTerm) !== false;
                        @endphp
                        <span
                          class="{{ $isMatch ? 'bg-indigo-100 text-indigo-800 ring-1 ring-indigo-200' : 'bg-gray-100 text-gray-600' }} inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium">
                          {{ $symptom->name }}
                        </span>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                  <a href="{{ route('diseases.index') }}?search={{ $disease->name }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                    Lihat Detail Lengkap
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      @else
        <!-- Empty State Awal -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
          <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
            <div
              class="bg-emerald-100 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-4 text-emerald-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h5 class="font-bold text-gray-900">Akurat</h5>
            <p class="text-sm text-gray-500 mt-1">Mencocokkan gejala dengan database medis.</p>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
            <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-4 text-blue-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
              </svg>
            </div>
            <h5 class="font-bold text-gray-900">Cepat</h5>
            <p class="text-sm text-gray-500 mt-1">Hasil pencarian instan dalam hitungan detik.</p>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
            <div
              class="bg-purple-100 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-4 text-purple-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
              </svg>
            </div>
            <h5 class="font-bold text-gray-900">Lengkap</h5>
            <p class="text-sm text-gray-500 mt-1">Informasi detail penyakit dan solusinya.</p>
          </div>
        </div>
      @endif

    </div>
  </div>
</x-app-layout>
