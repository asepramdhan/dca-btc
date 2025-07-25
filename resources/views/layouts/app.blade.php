<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    isDark: window.matchMedia('(prefers-color-scheme: dark)').matches
  }" x-init="
    $watch('isDark', value => {
      document.documentElement.classList.toggle('dark', value);
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
      isDark = e.matches;
    });

    document.documentElement.classList.toggle('dark', isDark);
  ">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Currency -->
  <script type="text/javascript" src="{{ asset('js/currency.js') }}"></script>
</head>
<body class="font-sans antialiased @if(!request()->is('guest/register') && !request()->is('guest/login') && !request()->is('upgrade')) bg-base-200 @endif">

  <!-- The navbar with `sticky` and `full-width` -->
  @unless(request()->is('guest/register') || request()->is('guest/login') || request()->is('upgrade'))
  <x-navbar />
  @endunless

  <!-- The main content with `full-width` -->
  <x-main with-nav full-width>

    <!-- This is a sidebar that works also as a drawer on small screens -->
    <!-- Notice the `main-drawer` reference here -->
    @unless(request()->is('/') || request()->is('guest/register') || request()->is('guest/login') || request()->is('upgrade'))
    <x-sidebar />
    @endunless

    <!-- The `$slot` goes here -->
    <x-slot:content>
      {{ $slot }}
    </x-slot:content>
  </x-main>

  <!-- TOAST area -->
  <x-mini-toast />
  <!-- Theme toggle -->
  <x-theme-toggle class="hidden" />
</body>
</html>
