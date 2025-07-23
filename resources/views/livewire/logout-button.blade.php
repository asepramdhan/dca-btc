<div>
  @if ($mode === 'icon')
  <!-- Tampilan sidebar: tombol bulat kecil -->
  <x-button icon="lucide.power" class="btn-circle btn-ghost btn-xs" tooltip-left="Logout" wire:click="logout" />
  @else
  <!-- Tampilan navbar: gaya menu item -->
  <div wire:click="logout" class="flex items-center gap-2 w-full cursor-pointer px-2 py-1">
    <x-icon name="lucide.log-out" class="w-5 h-5" />
    <span>Keluar</span>
  </div>
  @endif
</div>
