<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
      {{ __('Diagnosa Cepat') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Input Form (Sticky) -->
        <div class="lg:col-span-1">
          <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 sticky top-6">
            <div class="p-6">
              <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg mr-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                  </svg>
                </span>
                Parameter Diagnosa
              </h3>

              <!-- Alert Messages -->
              @if (session('success'))
                <div
                  class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm relative">
                  {{ session('success') }}
                </div>
              @endif
              @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm relative">
                  {{ session('error') }}
                </div>
              @endif

              <form method="POST" action="{{ route('diagnosis.quick-diagnose') }}">
                @csrf

                <!-- LOGIKA PILIH PASIEN -->
                <div class="mb-6">
                  <label class="block font-semibold text-sm text-gray-700 mb-2">Pasien</label>

                  @if (Auth::user()->role === 'admin')
                    <!-- TAMPILAN UNTUK ADMIN: Dropdown Pilih Pasien -->
                    <div class="relative">
                      <select name="patient_id_display"
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 pl-3 pr-10 text-sm">
                        <option value="">-- Mode Tamu (Tanpa Simpan) --</option>
                        <!-- Mengambil seluruh data user karena semua user dianggap pasien, DIURUTKAN A-Z -->
                        @foreach (\App\Models\User::where('role', '!=', 'admin')->orderBy('name', 'asc')->get() as $p)
                          <option value="{{ $p->id }}"
                            {{ request('patient_id_display') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }} ({{ optional($p->patient)->age ?? '-' }} Thn)
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 flex items-start">
                      <svg class="w-4 h-4 mr-1 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Wajib dipilih jika ingin menyimpan hasil.
                    </p>
                  @else
                    <!-- TAMPILAN UNTUK PASIEN: Info Diri Sendiri + Hidden Input -->
                    <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center">
                      <div class="flex-shrink-0 bg-indigo-200 rounded-full p-2 text-indigo-700 mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Diagnosa
                          Untuk:</p>
                        <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                      </div>
                    </div>

                    <!-- INPUT TERSEMBUNYI: Mengirim ID Pasien yang sedang login -->
                    <input type="hidden" name="patient_id_display" value="{{ Auth::id() }}">
                  @endif
                </div>

                <!-- Pilih Gejala -->
                <div>
                  <label class="block font-semibold text-sm text-gray-700 mb-2">Gejala yang
                    Dialami</label>
                  <div
                    class="border border-gray-200 rounded-xl max-h-[400px] overflow-y-auto bg-gray-50  p-2 space-y-1 custom-scrollbar">
                    @forelse($symptoms as $symptom)
                      <label
                        class="flex items-start p-2.5 rounded-lg cursor-pointer transition-colors hover:bg-white hover:shadow-sm">
                        <div class="flex items-center h-5">
                          <input type="checkbox" name="symptoms[]" value="{{ $symptom->id }}"
                            @if (in_array($symptom->id, $selectedSymptoms)) checked @endif
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                          <span class="font-medium text-gray-700">{{ $symptom->name }}</span>
                        </div>
                      </label>
                    @empty
                      <p class="text-center text-gray-400 py-4 text-sm">Belum ada data gejala.</p>
                    @endforelse
                  </div>
                  <p class="text-xs text-gray-500 mt-2 text-right">Total Gejala: {{ $symptoms->count() }}</p>
                </div>

                <button type="submit"
                  class="mt-6 w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-indigo-500/30">
                  Analisa Gejala
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Hasil Analisa -->
        <div class="lg:col-span-2">
          <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 min-h-[500px]">
            <div class="p-8">
              <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 text-rose-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Hasil Analisa Sistem
              </h3>

              @if ($results->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                  <div class="bg-gray-50 p-6 rounded-full mb-4">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                  </div>
                  <h4 class="text-lg font-medium text-gray-900">Belum ada hasil</h4>
                  <p class="text-gray-500 max-w-sm mt-2">
                    @if (empty($selectedSymptoms))
                      Silakan centang gejala yang dialami pada panel di sebelah kiri untuk memulai diagnosa.
                    @else
                      Tidak ditemukan penyakit yang cocok dengan kombinasi gejala yang dipilih.
                    @endif
                  </p>
                </div>
              @else
                <div class="space-y-6">
                  @foreach ($results as $disease)
                    <div
                      class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
                      <!-- Decorative top border -->
                      <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-rose-500"></div>

                      <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div class="flex-1">
                          <div class="flex items-center mb-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 mr-2">
                              Penyakit Terdeteksi
                            </span>
                            <h4 class="text-2xl font-bold text-gray-900">{{ $disease->name }}</h4>
                          </div>
                          <p class="text-gray-600 leading-relaxed mb-4">{{ $disease->description }}
                          </p>

                          <div class="bg-gray-50 rounded-lg p-4 mt-4">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Gejala yang
                              Cocok:</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                              @foreach ($disease->symptoms as $symptom)
                                <span
                                  class="{{ in_array($symptom->id, $selectedSymptoms) ? 'bg-indigo-100 text-indigo-700 border-indigo-200' : 'bg-gray-200  text-gray-500  border-gray-200 ' }} border px-3 py-1 rounded-full text-xs font-semibold">
                                  {{ $symptom->name }}
                                  @if (in_array($symptom->id, $selectedSymptoms))
                                    <span class="ml-1 text-indigo-500">✓</span>
                                  @endif
                                </span>
                              @endforeach
                            </div>
                          </div>
                        </div>

                        <!-- Action Form -->
                        <div class="md:w-48 flex-shrink-0 flex flex-col justify-end h-full">

                          <!-- PERUBAHAN DI SINI: Form hanya muncul jika role admin -->
                          @if (Auth::user()->role === 'admin')
                            <form action="{{ route('diagnosis.save') }}" method="POST" class="mt-4 md:mt-0">
                              @csrf
                              <input type="hidden" name="disease_id" value="{{ $disease->id }}">

                              @php
                                $symptomNames = \App\Models\Symptom::whereIn('id', $selectedSymptoms)
                                    ->pluck('name')
                                    ->implode(', ');
                              @endphp
                              <input type="hidden" name="symptoms_list" value="{{ $symptomNames }}">

                              <!-- Input Hidden untuk User ID (diisi via JS) -->
                              <input type="hidden" name="user_id" id="user_id_input_{{ $disease->id }}">

                              <button type="button" onclick="submitDiagnosis({{ $disease->id }})"
                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-emerald-500/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                  </path>
                                </svg>
                                Simpan Rekam Medis
                              </button>
                            </form>

                            <p class="text-[10px] text-gray-400 text-center mt-2">Pastikan Pasien dipilih.</p>
                          @endif
                          <!-- AKHIR PERUBAHAN -->

                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Script Handling -->
  <script>
    function submitDiagnosis(diseaseId) {
      // 1. Ambil Value - Selector kita ubah agar bisa menangkap baik SELECT maupun INPUT HIDDEN
      // Selector ini mencari elemen dengan name="patient_id_display" (bisa select, bisa input)
      var patientElement = document.querySelector('[name="patient_id_display"]');
      var selectedPatient = patientElement ? patientElement.value : null;

      // 2. Validasi (Khusus Admin yang mungkin lupa memilih)
      if (!selectedPatient) {
        alert(
          "Mohon Maaf:\n\nAnda harus memilih data 'Pasien' pada kolom kiri terlebih dahulu sebelum dapat menyimpan Rekam Medis."
        );

        // Jika elemennya adalah SELECT (Admin), kita kasih highlight
        if (patientElement.tagName === 'SELECT') {
          patientElement.focus();
          patientElement.classList.add('ring-2', 'ring-rose-500', 'border-rose-500');
        }
        return;
      }

      // 3. Masukkan ke Input Hidden Spesifik
      document.getElementById('user_id_input_' + diseaseId).value = selectedPatient;

      // 4. Submit
      document.getElementById('user_id_input_' + diseaseId).closest('form').submit();
    }
  </script>
</x-app-layout>
