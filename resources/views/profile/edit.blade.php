<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
      {{ __('Pengaturan Akun') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom Kiri: Informasi Profil -->
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-gray-100">
          <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
          </div>
        </div>

        <!-- Kolom Kanan: Update Password -->
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-gray-100">
          <div class="max-w-xl">
            @include('profile.partials.update-password-form')
          </div>
        </div>
      </div>

      <!-- Area Bahaya: Hapus Akun (Full Width) -->
      <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-red-100">
        <div class="max-w-xl">
          @include('profile.partials.delete-user-form')
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
