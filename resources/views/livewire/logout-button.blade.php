<div>
  @if ($mode === 'icon')
  <x-dropdown>
    <x-slot:trigger>
      <x-button icon="lucide.more-vertical" class="btn-circle btn-ghost btn-xs hover:bg-transparent hover:shadow-none hover:border-transparent" />
    </x-slot:trigger>

    <!-- Theme Toggle -->
    <div x-data="{
        theme: localStorage.getItem('theme') || 'auto',

        applyTheme() {
            if (this.theme === 'auto') {
                localStorage.removeItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', prefersDark);
                document.documentElement.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
            } else {
                localStorage.setItem('theme', this.theme);
                document.documentElement.classList.toggle('dark', this.theme === 'dark');
                document.documentElement.setAttribute('data-theme', this.theme);
            }

            window.dispatchEvent(new CustomEvent('mary-toggle-theme'));
        },

        init() {
            this.applyTheme();
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (this.theme === 'auto') {
                    document.documentElement.classList.toggle('dark', e.matches);
                    document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                    window.dispatchEvent(new CustomEvent('mary-toggle-theme'));
                }
            });
        }
    }" x-init="init()">
      <x-menu-sub title="Tampilan" icon="lucide.paintbrush">
        <!-- Auto Theme -->
        <x-menu-item title="Otomatis" icon="lucide.monitor" x-bind:class="theme === 'auto' ? 'bg-base-200' : ''" @click="theme = 'auto'; applyTheme()" />

        <!-- Dark Theme -->
        <x-menu-item title="Gelap" icon="lucide.moon" x-bind:class="theme === 'dark' ? 'bg-base-200' : ''" @click="theme = 'dark'; applyTheme()" />

        <!-- Light Theme -->
        <x-menu-item title="Terang" icon="lucide.sun" x-bind:class="theme === 'light' ? 'bg-base-200' : ''" @click="theme = 'light'; applyTheme()" />
      </x-menu-sub>
    </div>

    {{-- <x-menu-item title="Tampilan" icon="lucide.moon" @click="$dispatch('mary-toggle-theme')" /> --}}

    <x-menu-separator />

    <!-- Tombol Logout -->
    <!-- Tampilan navbar: gaya menu item -->
    <x-menu-item wire:click="logout">
      <x-icon name="lucide.log-out" class="w-5 h-5" />
      <span>Keluar</span>
    </x-menu-item>

  </x-dropdown>

  @else
  <!-- Tampilan navbar: gaya menu item -->
  <div wire:click="logout" class="flex items-center gap-2 w-full cursor-pointer px-2 py-1">
    <x-icon name="lucide.log-out" class="w-5 h-5" />
    <span>Keluar</span>
  </div>
  @endif
</div>
