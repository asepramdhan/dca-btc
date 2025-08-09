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
  <title>{{ isset($title) ? config('app.name').' - '.$title : config('app.name') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Currency -->
  <script type="text/javascript" src="{{ asset('js/currency.js') }}"></script>
  <!-- Snap -->
  {{-- <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
  </script> --}}

  <!-- Google tag (gtag.js) -->
  {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10783577109">
  </script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'AW-10783577109');

  </script>
  <!-- Event snippet for Kunjungan halaman conversion page -->
  <script>
    gtag('event', 'conversion', {
      'send_to': 'AW-10783577109/0A4VCJWR8f0aEJWogZYo'
      , 'value': 1.0
      , 'currency': 'IDR'
    });

  </script> --}}
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

  <!-- The navbar with `sticky` and `full-width` -->
  @unless(request()->is('guest/register') || request()->is('guest/login') || request()->is('auth/upgrade') || request()->is('guest/lupa-password') || request()->is('reset-password/*') || request()->is('admin/chat') || request()->is('admin/chat/*') || request()->is('auth/user/chat'))
  <x-navbar />
  @endunless

  <!-- The main content with `full-width` -->
  <x-main with-nav full-width>

    <!-- This is a sidebar that works also as a drawer on small screens -->
    <!-- Notice the `main-drawer` reference here -->
    @unless(request()->is('/') || request()->is('guest/register') || request()->is('guest/login') || request()->is('auth/upgrade') || request()->is('guest/lupa-password') || request()->is('reset-password/*') || request()->is('admin/chat') || request()->is('admin/chat/*') || request()->is('auth/user/chat'))
    <x-sidebar />
    @endunless

    <!-- The `$slot` goes here -->
    <x-slot:content>
      @unless(request()->is('/') || request()->is('guest/register') || request()->is('guest/login') || request()->is('auth/dashboard') || request()->is('auth/upgrade') || request()->is('guest/lupa-password') || request()->is('reset-password/*') || request()->is('admin/chat') || request()->is('admin/chat/*') || request()->is('auth/user/chat'))
      <div class="bg-base-200 mb-4">
        <x-app-breadcrumbs :items="breadcrumbs()" />
      </div>
      @endunless
      {{ $slot }}
    </x-slot:content>
  </x-main>

  <!-- TOAST area -->
  <x-mini-toast />
  <!-- Theme toggle -->
  <x-theme-toggle class="hidden" />
</body>
</html>
