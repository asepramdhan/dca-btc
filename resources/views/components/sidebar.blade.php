<div>
  @php
  $user = auth()->user();
  $isPremium = $user?->premium_until;
  @endphp
  <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200 lg:bg-inherit" collapse-text="Tutup" collapse-icon="lucide.chevron-right" open-collapse-icon="lucide.chevron-left" right>

    <!-- User -->
    @if($user)
    <x-list-item :item="$user" no-separator no-hover class="py-4">
      <x-slot:avatar>
        <x-avatar :placeholder="Str::upper(Str::substr($user->name, 0, 1))" class="!w-10" />
      </x-slot:avatar>
      <x-slot:value>
        {{ Str::title($user->name) }}
      </x-slot:value>
      <x-slot:sub-value>
        {{ $user->email }}
        <div>
          @if($isPremium)
          <x-badge value="Premium" class="badge-primary badge-soft badge-sm" />
          <span class="text-xs">{!! $getPremiumStatus($user) !!}</span>
          @else
          <x-badge value="Free" class="badge-soft badge-sm" />
          <x-button label="Upgrade" class="btn-ghost btn-sm text-blue-500 hover:bg-transparent hover:shadow-none hover:border-transparent" link="/upgrade" />
          @endif
        </div>
      </x-slot:sub-value>
      <x-slot:actions>
        <livewire:logout-button />
      </x-slot:actions>
    </x-list-item>
    @endif

    <!-- Activates the menu item when a route matches the `link` property -->
    <x-menu activate-by-route>
      <x-menu-item title="Dashboard" icon="lucide.layout-dashboard" class="text-secondary" icon-classes="text-secondary" :link="route('dashboard')" />
      <x-menu-item title="Investasi" icon="lucide.vault" :link="route('investasi')" />
      <x-menu-item title="Dana Darurat" icon="lucide.siren" :link="route('dana-darurat')" />
      <x-menu-item title="Dana Harian" icon="lucide.wallet" :link="route('dana-harian')" />
      <!-- Pengaturan User -->
      <x-menu-sub title="Pengaturan" icon="lucide.settings">
        <x-menu-item title="Exchange" icon="lucide.repeat" :link="route('exchange')" />
        <x-menu-item title="Profil" icon="lucide.user-circle" :link="route('profil')" />
        <x-menu-item title="PIN" icon="lucide.key" :link="route('pin')" />
      </x-menu-sub>
      @admin
      <!-- Pengaturan Admin -->
      <x-menu-sub title="Admin" icon="lucide.wrench">
        <x-menu-item title="Users" icon="lucide.user-cog" :link="route('admin.user')" />
        <x-menu-item title="Maintenance" icon="lucide.server-cog" :link="route('admin.maintenance')" />
      </x-menu-sub>
      @endadmin
    </x-menu>
  </x-slot:sidebar>
</div>
