<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-bold text-xl text-gray-800 leading-tight">
        Detail Rekam Medis
      </h2>
      <span class="text-sm text-gray-500">ID: #{{ str_pad($visit->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <!-- Kartu Laporan -->
      <div
        class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 relative print:shadow-none print:border-none">

        <!-- Hiasan Garis Atas -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500 print:hidden"></div>

        <div class="p-8">

          <!-- Kop Laporan -->
          <div class="flex justify-between items-start mb-8 pb-6 border-b border-gray-100">
            <div>
              <h1 class="text-3xl font-bold text-gray-900">Laporan Medis</h1>
              <p class="text-gray-500 text-sm mt-1">Sistem Diagnosa Digital</p>
            </div>
            <div class="text-right">
              <p class="text-sm font-semibold text-gray-600">Tanggal Pemeriksaan</p>
              <p class="text-lg font-bold text-indigo-600">
                {{ $visit->created_at->translatedFormat('d F Y') }}
              </p>
              <p class="text-sm text-gray-500">{{ $visit->created_at->format('H:i') }} WIB</p>
            </div>
          </div>

          <!-- Bagian 1: Data Pasien -->
          <div class="mb-8">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Pasien</h4>
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="flex items-start">
                  <div class="bg-white p-2 rounded-lg shadow-sm mr-3 text-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500">Nama Lengkap</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $visit->patient->name ?? 'Data Terhapus' }}</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="bg-white p-2 rounded-lg shadow-sm mr-3 text-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                      </path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500">Usia & Gender</p>
                    <p class="font-bold text-gray-900">
                      {{ $visit->patient?->patient?->age ?? '-' }} Tahun /
                      {{ $visit->patient?->patient?->gender ?? '-' }}
                    </p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="bg-white p-2 rounded-lg shadow-sm mr-3 text-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                      </path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500">Kontak</p>
                    <p class="font-bold text-gray-900">{{ $visit->patient?->patient?->phone ?? '-' }}</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="bg-white p-2 rounded-lg shadow-sm mr-3 text-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500">Alamat</p>
                    <p class="font-bold text-gray-900">{{ $visit->patient?->patient?->address ?? '-' }}</p>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- Bagian 2: Hasil Diagnosa -->
          <div class="mb-8">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Hasil Analisa Klinis</h4>

            <div class="border-l-4 border-rose-500 pl-4 mb-6">
              <p class="text-sm text-gray-500 mb-1">Penyakit Terdeteksi</p>
              <h2 class="text-3xl font-extrabold text-gray-900">
                {{ $visit->disease->name ?? 'Tidak Teridentifikasi' }}
              </h2>
              <p class="text-gray-600 mt-2 italic leading-relaxed">
                "{{ $visit->disease->description ?? '-' }}"
              </p>
            </div>

            <div class="grid grid-cols-1 gap-4">
              <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                <p class="text-xs font-bold text-yellow-700 uppercase mb-2">Gejala yang Dilaporkan</p>
                <p class="text-gray-800 text-sm font-medium">
                  {{ $visit->symptoms_snapshot ?? 'Tidak ada data gejala.' }}
                </p>
              </div>

              @if ($visit->notes)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                  <p class="text-xs font-bold text-gray-500 uppercase mb-2">Catatan Tambahan</p>
                  <p class="text-gray-700 text-sm">
                    {{ $visit->notes }}
                  </p>
                </div>
              @endif
            </div>
          </div>

          <!-- Footer Action -->
          <div
            class="pt-6 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 print:hidden">
            <a href="{{ route('visits.index') }}"
              class="text-gray-500 hover:text-gray-800 font-medium text-sm flex items-center transition">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
              </svg>
              Kembali ke Daftar
            </a>

            <button onclick="window.print()"
              class="bg-gray-900 text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-gray-800 transition shadow-lg flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                </path>
              </svg>
              Cetak Laporan (PDF)
            </button>
          </div>

        </div>
      </div>

      <div class="mt-6 text-center text-xs text-gray-400 print:hidden">
        &copy; {{ date('Y') }} Sistem Informasi Klinik. Dokumen ini bersifat rahasia.
      </div>

    </div>
  </div>
</x-app-layout>
