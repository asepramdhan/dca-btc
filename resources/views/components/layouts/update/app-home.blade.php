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
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

  {{-- The navbar with `sticky` and `full-width` --}}
  <x-nav class="bg-base-200" sticky full-width>

    <x-slot:brand>
      {{-- Brand --}}
      <a href="/update" wire:navigate class="flex items-center">
        <span class="font-bold text-3xl me-3 bg-gradient-to-r from-purple-500 to-pink-300 bg-clip-text text-transparent">PortoKu</span>
      </a>
    </x-slot:brand>

    {{-- Right side actions --}}
    <x-slot:actions class="space-x-2">
      <div class="hidden lg:flex space-x-2">
        <x-button label="Blog" class="btn-ghost" link="###" />
        <x-button label="Pricing" class="btn-ghost" link="###" />
        <x-button label="Contact" class="btn-ghost" link="###" />
        <x-button label="About" class="btn-ghost" link="###" />
      </div>

      <div class="text-gray-300 hidden lg:block">|</div>

      <x-button class="btn-ghost btn-circle btn-sm">
        <x-swap id="rotate" class="swap-rotate" />
      </x-button>

      <div class="text-gray-300">|</div>

      <x-dropdown>
        <x-slot:trigger>
          <x-button icon="o-bell" class="btn-ghost btn-circle btn-sm indicator">
            <x-badge value="7" class="badge-secondary badge-sm indicator-item" />
          </x-button>
        </x-slot:trigger>

        <x-menu-item title="Archive" />
        <x-menu-item title="Move" />
      </x-dropdown>

      <x-dropdown label="Hello" class="btn-warning btn-sm" right>
        <x-menu-item title="It should align correctly on right side" />
        <x-menu-item title="Yes!" />
      </x-dropdown>
    </x-slot:actions>
  </x-nav>

  <!-- The main content with `full-width` -->
  <x-main with-nav full-width>
    <!-- This is a sidebar that works also as a drawer on small screens -->

    <!-- The `$slot` goes here -->
    <x-slot:content>
      {{ $slot }}
    </x-slot:content>

    <x-slot:footer class="footer sm:footer-horizontal bg-base-200 text-base-content p-10">
      <aside>
        <img src="{{ asset('images/logo2.png') }}" alt="portoku.id" class="h-10">
        <p>
          PortoKu Industries Ltd.
          <br />
          Providing reliable tech since 2022
        </p>
      </aside>
      <nav>
        <h6 class="footer-title">Services</h6>
        <a class="link link-hover">Branding</a>
        <a class="link link-hover">Design</a>
        <a class="link link-hover">Marketing</a>
        <a class="link link-hover">Advertisement</a>
      </nav>
      <nav>
        <h6 class="footer-title">Company</h6>
        <a class="link link-hover">About us</a>
        <a class="link link-hover">Contact</a>
        <a class="link link-hover">Jobs</a>
        <a class="link link-hover">Press kit</a>
      </nav>
      <nav>
        <h6 class="footer-title">Legal</h6>
        <a class="link link-hover">Terms of use</a>
        <a class="link link-hover">Privacy policy</a>
        <a class="link link-hover">Cookie policy</a>
      </nav>
    </x-slot:footer>
  </x-main>

  <!-- TOAST area -->
  <x-toast />
  <!-- Theme toggle -->
  <x-theme-toggle class="hidden" />
</body>
</html>
