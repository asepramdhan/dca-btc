<x-nav sticky full-width class="bg-base-200">

  <x-slot:brand>
    <!-- Drawer toggle for "main-drawer" -->
    @unless(request()->is('/') || request()->is('guest/register') || request()->is('guest/login'))
    <label for="main-drawer" class="lg:hidden mr-3">
      <x-icon name="lucide.menu" class="cursor-pointer" />
    </label>
    @endunless

    <!-- Brand -->
    <div class="hidden lg:block">
      <a href="{{ route('home') }}" wire:navigate>DCA-BTC</a>
    </div>
  </x-slot:brand>

  <!-- Right side actions -->
  <x-slot:actions>
    @guest
    <x-button label="Registrasi" icon="lucide.user-pen" :link="route('register')" class="btn-ghost btn-sm" responsive />
    <x-button label="Masuk" icon="lucide.user-circle-2" :link="route('login')" class="btn-ghost btn-sm" responsive />
    @else
    <x-button icon="lucide.message-circle-off" class="btn-circle btn-ghost btn-sm" /> <!-- icon="lucide.message-circle" -->
    <x-dropdown>
      <x-slot:trigger>
        <x-button icon="lucide.bell" class="btn-circle btn-ghost btn-sm " /> <!-- icon="lucide.bell-dot" -->
      </x-slot:trigger>
      <x-menu-item title="You have 10 messages" icon="lucide.alert-triangle" />
    </x-dropdown>
    @if(request()->is('/'))
    <x-dropdown label="Hello Ramdan" class="btn-ghost btn-sm" right>
      <x-menu-item title="Dashboard" icon="lucide.layout-dashboard" class="text-secondary" icon-classes="text-secondary" :link="route('dashboard')" />
      <x-menu-item title="Pengaturan" icon="lucide.settings-2" />

      <x-menu-separator />

      <x-menu-item>
        <livewire:logout-button mode="menu" />
      </x-menu-item>

    </x-dropdown>
    @endif
    @endguest
  </x-slot:actions>
</x-nav>
