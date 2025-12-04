<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-gray-900">
  <div class="flex min-h-full">

    <!-- Sisi Kiri: Form -->
    <div
      class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white z-10 relative">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <!-- Logo -->
        <div class="mb-10">
          <a href="/">
            <x-application-logo class="w-12 h-12 fill-current text-indigo-600" />
          </a>
        </div>

        <!-- Slot Content -->
        {{ $slot }}

        <!-- FOOTER GUEST (Di bawah tombol login/register) -->
        <div class="mt-10 pt-6 border-t border-gray-100 text-center">
          <p class="text-xs text-gray-400">
            &copy; {{ date('Y') }} Kelompok 7.
            <br class="sm:hidden">
            Klinik Kesehatan Modern.
          </p>
        </div>
      </div>
    </div>

    <!-- Sisi Kanan: Gambar Artistik -->
    <div class="relative hidden w-0 flex-1 lg:block">
      <img class="absolute inset-0 h-full w-full object-cover"
        src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2564&auto=format&fit=crop"
        alt="Background Modern">

      <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

      <div class="absolute bottom-10 left-10 text-white z-20">
        <h3 class="text-3xl font-bold">Welcome Aboard.</h3>
        <p class="mt-2 text-gray-200">Kelola aktivitasmu bersama DecoSandyFaiz.</p>
      </div>
    </div>
  </div>
</body>

</html>
