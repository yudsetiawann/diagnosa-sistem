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
              <!-- Tambahkan tag <a> pembungkus yang mengarah ke route show -->
              <a href="{{ route('diagnosis.disease.show', $disease) }}" class="block group">
                <div
                  class="bg-gray-50rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-[1.02] hover:bg-white h-full border border-transparent hover:border-indigo-200">
                  <div class="p-6">
                    <div class="flex justify-between items-start">
                      <h4
                        class="text-xl font-bold text-indigo-600 group-hover:text-indigo-700 transition-colors">
                        {{ $disease->name }}
                      </h4>
                      <!-- Ikon panah kecil -->
                      <svg class="w-5 h-5 text-gray-300 group-hover:text-indigo-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                      </svg>
                    </div>

                    <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                      {{ $disease->description }}
                    </p>

                    <hr class="my-4">

                    <h5 class="font-semibold mb-2 text-xs text-gray-500 uppercase tracking-wide">Gejala Terkait:</h5>
                    <div class="flex flex-wrap gap-2">
                      @foreach ($disease->symptoms->take(3) as $symptom)
                        <span @class([
                            'inline-block rounded-full px-2 py-1 text-xs font-semibold',
                            'bg-indigo-100 text-indigo-800' =>
                                stripos($symptom->name, $searchTerm) !== false,
                            'bg-gray-200 text-gray-600' =>
                                stripos($symptom->name, $searchTerm) === false,
                        ])>
                          {{ $symptom->name }}
                        </span>
                      @endforeach
                      @if ($disease->symptoms->count() > 3)
                        <span
                          class="inline-block rounded-full px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-500">
                          +{{ $disease->symptoms->count() - 3 }} lagi
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
              </a>
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
