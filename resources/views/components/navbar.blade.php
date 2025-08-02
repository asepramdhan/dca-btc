<x-nav sticky full-width class="bg-base-200">

  <x-slot:brand>
    <!-- Drawer toggle for "main-drawer" -->
    @unless(request()->is('/') || request()->is('guest/register') || request()->is('guest/login'))
    <label for="main-drawer" class="lg:hidden mr-3">
      <x-icon name="lucide.menu" class="cursor-pointer" />
    </label>
    @endunless

    <!-- Brand -->
    <div class="lg:block {{ request()->is('/') ? '' : 'hidden' }}">
      <a href="/" wire:navigate>
        <img src="{{ asset('images/logo.png') }}" alt="dca-btc" class="h-10">
      </a>
    </div>
  </x-slot:brand>

  <!-- Right side actions -->
  <x-slot:actions>
    @guest
    <x-button label="Daftar" icon="lucide.user-pen" link="/guest/register" class="btn-ghost btn-sm" responsive />
    <x-button label="Masuk" icon="lucide.user-circle-2" link="/guest/login" class="btn-ghost btn-sm" responsive />
    @else
    @unless(request()->is('/'))
    <livewire:btc-price />
    <div>
      @admin
      <x-button icon="lucide.message-circle" class="btn-circle btn-ghost btn-sm hover:bg-transparent hover:shadow-none hover:border-transparent indicator" link="/admin/chat" external>
        <livewire:chat-notification-badge />
      </x-button>
      @else
      <x-button icon="lucide.message-circle" class="btn-circle btn-ghost btn-sm hover:bg-transparent hover:shadow-none hover:border-transparent indicator" link="/auth/user/chat" external>
        <livewire:chat-notification-badge />
      </x-button>
      @endadmin
      <x-dropdown>
        <x-slot:trigger>
          <x-button icon="lucide.bell" class="btn-circle btn-ghost btn-sm hover:bg-transparent hover:shadow-none hover:border-transparent" /> <!-- icon="lucide.bell-dot" -->
        </x-slot:trigger>
        <x-menu-item title="You have 10 messages" icon="lucide.alert-triangle" />
      </x-dropdown>
    </div>
    @endunless
    @if(request()->is('/'))
    <x-dropdown label="Hai {{ Str::title(auth()->user()->name) }}" class="btn-ghost btn-sm hover:bg-transparent hover:shadow-none hover:border-transparent" right>
      <x-menu-item title="Dashboard" icon="lucide.layout-dashboard" class="text-secondary" icon-classes="text-secondary" link="/auth/dashboard" />
      <x-menu-item title="Pengaturan" icon="lucide.settings-2" link="/auth/profil" />

      <x-menu-separator />

      <x-menu-item>
        <livewire:logout-button mode="menu" />
      </x-menu-item>

    </x-dropdown>
    @endif
    @endguest
  </x-slot:actions>
</x-nav>
