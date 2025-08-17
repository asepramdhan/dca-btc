<aside id="sidebar" :class="{'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen}" class="bg-slate-900 w-64 p-6 fixed inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 flex flex-col">
  <div class="flex justify-between items-center mb-10">
    <a href="/update" class="text-2xl font-bold text-white">
      Porto<span class="text-sky-400">Ku</span>.id
    </a>
    <button id="close-sidebar-btn" @click="isSidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white cursor-pointer">
      <x-icon name="lucide.x" />
    </button>
  </div>
  <nav class="flex flex-col space-y-2">
    <a href="/update/dashboard" wire:navigate class="sidebar-link {{ request()->is('update/dashboard') ? 'active' : '' }}">
      <x-icon name="lucide.layout-dashboard" class="mr-3" />
      Dashboard
    </a>
    <a href="/update/portofolio" wire:navigate class="sidebar-link {{ request()->is('update/portofolio') ? 'active' : '' }}">
      <x-icon name="lucide.bitcoin" class="mr-3" />
      Portofolio
    </a>
    <a href="/update/transactions" wire:navigate class="sidebar-link {{ request()->is('update/transactions') ? 'active' : '' }}">
      <x-icon name="lucide.arrow-right-left" class="mr-3" />
      Transaksi
    </a>
    <a href="/update/reports" wire:navigate class="sidebar-link {{ request()->is('update/reports') ? 'active' : '' }}">
      <x-icon name="lucide.pie-chart" class="mr-3" />
      Laporan
    </a>
    <a href="/update/settings" wire:navigate class="sidebar-link {{ request()->is('update/settings') ? 'active' : '' }}">
      <x-icon name="lucide.settings" class="mr-3" />
      Pengaturan
    </a>
  </nav>
  <div class="mt-auto">
    <livewire:update.logout />
  </div>
</aside>
