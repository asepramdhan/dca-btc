<div>
  <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200 lg:bg-inherit" collapse-text="Tutup" collapse-icon="lucide.chevron-right" open-collapse-icon="lucide.chevron-left" right>

    <div class="flex items-center space-x-2 px-6 pt-4 lg:hidden">
      <a href="/" wire:navigate class="flex items-center">
        <img src="{{ asset('images/logo.png') }}" alt="dca-btc" class="h-10">
      </a>
    </div>

    <!-- User -->
    @if($user)
    <x-list-item :item="$user" no-separator no-hover class="py-2">
      <x-slot:avatar>
        <x-avatar :placeholder="Str::upper(Str::substr($user->name, 0, 1))" class="!w-10" />
      </x-slot:avatar>
      <x-slot:value>
        {{ Str::title($user->name) }}
      </x-slot:value>
      <x-slot:sub-value>
        {{ $user->email }}
        <div>
          @if ($isStillPremium)
          <x-badge value="Premium" class="badge-primary badge-soft badge-sm" />
          <span class="text-xs">{{ $premiumStatus }}</span>

          @elseif ($isFreeTrial)
          <x-badge value="Free Trial" class="badge-info badge-soft badge-sm" />
          <span class="text-xs">{{ $premiumStatus }}</span>

          @elseif ($isFree)
          <x-badge value="Free" class="badge-muted badge-soft badge-sm" />
          <x-button label="Upgrade" class="btn-ghost btn-sm text-blue-500 hover:bg-transparent hover:shadow-none hover:border-transparent" link="/auth/upgrade" no-wire-navigate />
          @endif
        </div>
      </x-slot:sub-value>
      <x-slot:actions>
        <livewire:logout-button />
      </x-slot:actions>
    </x-list-item>
    @endif

    <x-menu-separator />

    <!-- Activates the menu item when a route matches the `link` property -->
    <x-menu activate-by-route>
      <x-menu-item title="Dashboard" icon="lucide.layout-dashboard" class="text-secondary" icon-classes="text-secondary" :link="route('dashboard')" />
      <x-menu-item title="Investasi" icon="lucide.vault" :link="route('investasi')" />
      <x-menu-item title="Dana Darurat" icon="lucide.siren" :link="route('dana-darurat')" />
      <x-menu-item title="Dana Harian" icon="lucide.wallet" :link="route('dana-harian')" />
      <x-menu-item title="Transaksi" icon="lucide.receipt-text" link="/auth/transactions" />
      <x-menu-item title="Voucher" icon="lucide.gift" link="/auth/voucher" />
      <!-- Pengaturan User -->
      <x-menu-sub title="Pengaturan" icon="lucide.settings">
        <x-menu-item title="Exchange" icon="lucide.repeat" :link="route('exchange')" />
        <x-menu-item title="Profil" icon="lucide.user-circle" :link="route('profil')" />
        <x-menu-item title="PIN" icon="lucide.key" :link="route('pin')" />
        <x-menu-item title="Reset Password" icon="lucide.lock-keyhole" :link="route('reset-password')" />
      </x-menu-sub>
      @admin

      <x-menu-separator />

      <x-menu-item>
        My <b>admin</b>
      </x-menu-item>

      <!-- Pengaturan Admin -->
      <!-- 📁 Management -->
      <x-menu-sub title="Management" icon="lucide.settings">
        <x-menu-item title="Users" icon="lucide.user-cog" link="/admin/users" />
        <x-menu-item title="Maintenance" icon="lucide.server-cog" link="/admin/maintenance" />
      </x-menu-sub>

      <!-- 💳 Paket & Transaksi -->
      <x-menu-sub title="Paket & Transaksi" icon="lucide.credit-card">
        <x-menu-item title="Daftar Paket" icon="lucide.layers" link="/admin/paket" />
        <x-menu-item title="Transaksi" icon="lucide.receipt-text" link="/admin/transactions" />
        <x-menu-item title="Voucher" icon="lucide.gift" link="/admin/voucher" />
      </x-menu-sub>

      <!-- ⚙️ Pengaturan Sistem -->
      <x-menu-sub title="Pengaturan" icon="lucide.sliders-horizontal">
        {{-- <x-menu-item title="Testing Chat" icon="lucide.message-circle" :link="route('admin-testing-chat')" /> --}}
        <x-menu-item title="Konfigurasi Umum" icon="lucide.settings" link="/admin/settings" />
      </x-menu-sub>

      @endadmin
    </x-menu>
  </x-slot:sidebar>
</div>
