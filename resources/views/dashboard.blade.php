<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
      {{ __('Dashboard Klinik') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <!-- Welcome Banner Modern -->
      <div
        class="relative bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 shadow-lg mb-8 overflow-hidden">
        <!-- Decorative Circles -->
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white opacity-10 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-white opacity-10 blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center text-white">
          <div>
            <h3 class="text-3xl font-bold">Halo, {{ Auth::user()->name }}! 👋</h3>
            <p class="mt-2 text-indigo-100 text-lg opacity-90">
              Selamat datang kembali. Sistem siap membantu diagnosa hari ini.
            </p>
          </div>
          <div class="mt-6 md:mt-0 hidden md:block">
            <span class="bg-white/20 backdrop-blur-md border border-white/30 px-4 py-2 rounded-xl text-sm font-medium">
              {{ now()->translatedFormat('l, d F Y') }}
            </span>
          </div>
        </div>
      </div>

      <!-- Notifikasi Data Belum Lengkap (Hanya untuk Pasien) -->
      @php
        $patient = Auth::user()->patient;
        $isProfileIncomplete =
            $patient &&
            ($patient->age == 0 || // Gunakan == agar string '0' atau int 0 terbaca
                is_null($patient->age) || // Tangkap jika database NULL
                $patient->phone === '-' ||
                empty($patient->phone));
      @endphp

      @if ($isProfileIncomplete && Auth::user()->role !== 'admin')
        <div class="mb-8 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-sm">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3 w-full flex justify-between items-center">
              <div>
                <h3 class="text-sm font-bold text-yellow-800 dark:text-yellow-200">Data Profil Belum Lengkap</h3>
                <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                  Mohon lengkapi data usia dan nomor telepon Anda untuk memudahkan proses administrasi rekam medis.
                </p>
              </div>
              <a href="{{ route('profile.edit') }}"
                class="whitespace-nowrap bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 text-xs font-bold px-4 py-2 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-700 transition">
                Lengkapi Sekarang &rarr;
              </a>
            </div>
          </div>
        </div>
      @endif

      <!-- Statistik Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Card Pasien -->
        <div
          class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
          <div class="flex justify-between items-start">
            <div>
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pasien</p>
              <h4 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $totalPatients }}</h4>
              <p class="text-sm text-gray-500 mt-1">Orang terdaftar</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Card Penyakit -->
        <div
          class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
          <div class="flex justify-between items-start">
            <div>
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Database Penyakit</p>
              <h4 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $totalDiseases }}</h4>
              <p class="text-sm text-gray-500 mt-1">Jenis penyakit</p>
            </div>
            <div class="p-3 bg-rose-50 rounded-xl text-rose-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                </path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Card Gejala -->
        <div
          class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
          <div class="flex justify-between items-start">
            <div>
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Gejala Terdaftar</p>
              <h4 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $totalSymptoms }}</h4>
              <p class="text-sm text-gray-500 mt-1">Indikator medis</p>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                </path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Grafik & Shortcut Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Grafik Kunjungan -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-900">Analitik Kunjungan</h3>
            <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-1 rounded-md">7 Hari Terakhir</span>
          </div>
          <div class="relative h-72 w-full">
            <canvas id="visitChart"></canvas>
          </div>
        </div>

        <!-- Menu Cepat (Quick Actions) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
          <h3 class="text-lg font-bold text-gray-900 mb-6">Akses Cepat</h3>

          <div class="space-y-4 flex-1">
            <!-- Tombol 1 -->
            <a href="{{ route('diagnosis.quick-view') }}"
              class="group flex items-center p-4 bg-gray-50 hover:bg-indigo-50 border border-transparent hover:border-indigo-100 rounded-xl transition-all duration-200 cursor-pointer">
              <div
                class="h-10 w-10 bg-white group-hover:bg-indigo-600 rounded-lg shadow-sm flex items-center justify-center text-indigo-600 group-hover:text-white transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                  </path>
                </svg>
              </div>
              <div class="ml-4">
                <h5 class="font-bold text-gray-900 group-hover:text-indigo-700">Diagnosa Cepat</h5>
                <p class="text-xs text-gray-500 group-hover:text-indigo-500">Mulai pemeriksaan pasien</p>
              </div>
              <div class="ml-auto text-gray-400 group-hover:text-indigo-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </a>

            <!-- Tombol 2 -->
            <a href="{{ route('patients.create') }}"
              class="group flex items-center p-4 bg-gray-50 hover:bg-blue-50 border border-transparent hover:border-blue-100 rounded-xl transition-all duration-200 cursor-pointer">
              <div
                class="h-10 w-10 bg-white group-hover:bg-blue-600 rounded-lg shadow-sm flex items-center justify-center text-blue-600 group-hover:text-white transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <h5 class="font-bold text-gray-900 group-hover:text-blue-700">Tambah Pasien</h5>
                <p class="text-xs text-gray-500 group-hover:text-blue-500">Registrasi pasien baru</p>
              </div>
              <div class="ml-auto text-gray-400 group-hover:text-blue-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </a>

            <!-- Tombol 3 -->
            <a href="{{ route('diagnosis.search') }}"
              class="group flex items-center p-4 bg-gray-50 hover:bg-purple-50 border border-transparent hover:border-purple-100 rounded-xl transition-all duration-200 cursor-pointer">
              <div
                class="h-10 w-10 bg-white group-hover:bg-purple-600 rounded-lg shadow-sm flex items-center justify-center text-purple-600 group-hover:text-white transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <h5 class="font-bold text-gray-900 group-hover:text-purple-700">Cari Manual</h5>
                <p class="text-xs text-gray-500 group-hover:text-purple-500">Cari penyakit by gejala</p>
              </div>
              <div class="ml-auto text-gray-400 group-hover:text-purple-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Script Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('visitChart');
    if (ctx) {
      // Setup Gradient untuk Chart
      const chartCanvas = ctx.getContext('2d');
      const gradient = chartCanvas.createLinearGradient(0, 0, 0, 400);
      gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)'); // Warna atas
      gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)'); // Warna bawah transparan

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: @json($chartData['labels']),
          datasets: [{
            label: 'Kunjungan Pasien',
            data: @json($chartData['data']),
            borderColor: '#4F46E5', // Indigo-600
            backgroundColor: gradient,
            borderWidth: 3,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#4F46E5',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            tension: 0.4, // Membuat garis lebih smooth (lengkung)
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              backgroundColor: '#1F2937',
              padding: 12,
              titleFont: {
                size: 13
              },
              bodyFont: {
                size: 14,
                weight: 'bold'
              },
              displayColors: false,
              cornerRadius: 8,
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: '#F3F4F6',
                borderDash: [5, 5]
              },
              ticks: {
                stepSize: 1, // Pastikan angka bulat karena orang tidak mungkin desimal
                font: {
                  family: "'Inter', sans-serif",
                  size: 11
                }
              },
              border: {
                display: false
              }
            },
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  family: "'Inter', sans-serif",
                  size: 11
                }
              },
              border: {
                display: false
              }
            }
          }
        }
      });
    }
  </script>
</x-app-layout>
