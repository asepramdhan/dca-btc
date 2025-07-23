<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!--  Currency  -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
  <!-- Flatpickr Core -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <!-- Tambahkan locale yang kamu butuhkan -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script> {{-- Bahasa Indonesia --}}

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      flatpickr.localize(flatpickr.l10ns.id); // Ganti 'id' sesuai kebutuhan
    });

  </script>
</head>
<body class="font-sans antialiased @if(!request()->is('guest/register') && !request()->is('guest/login')) bg-base-200 @endif">

  <!-- The navbar with `sticky` and `full-width` -->
  @unless(request()->is('guest/register') || request()->is('guest/login'))
  <x-navbar />
  @endunless

  <!-- The main content with `full-width` -->
  <x-main with-nav full-width>

    <!-- This is a sidebar that works also as a drawer on small screens -->
    <!-- Notice the `main-drawer` reference here -->
    @unless(request()->is('/') || request()->is('guest/register') || request()->is('guest/login'))
    <x-sidebar />
    @endunless

    <!-- The `$slot` goes here -->
    <x-slot:content>
      {{ $slot }}
    </x-slot:content>
  </x-main>

  <!-- TOAST area -->
  <x-mini-toast />
</body>
</html>
