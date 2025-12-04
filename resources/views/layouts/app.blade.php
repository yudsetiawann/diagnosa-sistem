<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-full">
  <!--
            Tambahkan 'flex flex-col' pada container utama
            agar footer bisa didorong ke bawah (Sticky Footer)
        -->
  <div class="min-h-screen bg-gray-50 flex flex-col justify-between">

    <!-- Wrapper Konten Utama -->
    <div>
      @include('layouts.navigation')

      <!-- Page Heading -->
      @isset($header)
        <header class="bg-white shadow-sm border-b border-gray-100">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
          </div>
        </header>
      @endisset

      <!-- Page Content -->
      <main>
        {{ $slot }}
      </main>
    </div>

    <!-- FOOTER SECTION -->
    <footer class="bg-white border-t border-gray-200 mt-12">
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">

        <!-- Kiri: Copyright -->
        <div class="text-center md:text-left mb-4 md:mb-0">
          <p class="text-sm text-gray-500">
            &copy; {{ date('Y') }} <span class="font-bold text-gray-700">{{ config('app.name') }}</span>. Kelompok 7.
          </p>
        </div>

        <!-- Kanan: Link Tambahan / Credits -->
        {{-- <div class="flex space-x-6 text-sm text-gray-400">
          <a href="#" class="hover:text-indigo-600 transition">Privacy Policy</a>
          <a href="#" class="hover:text-indigo-600 transition">Terms of Service</a>
          <span class="text-gray-300">|</span>
          <span>Made with <span class="text-red-500">❤</span> for Health</span>
        </div> --}}
      </div>
    </footer>

  </div>
</body>

</html>
