<header class="bg-slate-900/80 backdrop-blur-sm border-b border-slate-800 p-4 flex justify-between items-center lg:justify-end sticky top-0 z-30">
  <button id="open-sidebar-btn" @click="isSidebarOpen = true" class="lg:hidden text-white mr-4 cursor-pointer">
    <x-icon name="lucide.menu" class="w-6 h-6" />
  </button>
  <div class="flex items-center space-x-4">
    <button class="text-slate-400 hover:text-white cursor-pointer">
      <x-icon name="lucide.bell" class="w-6 h-6" />
    </button>
    <div class="flex items-center space-x-2">
      <img src="https://placehold.co/40x40/0EA5E9/FFFFFF?text=U" alt="User Avatar" class="w-8 h-8 rounded-full">
      <span class="text-white font-semibold hidden sm:block">Nama User</span>
    </div>
  </div>
</header>
