<div class="flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <x-card shadow separator>
      <x-slot:title>
        <div class="flex justify-between w-full">
          Registrasi
          <!-- Tombol kembali ke halaman utama -->
          <x-button icon="lucide.house" class="btn-circle btn-ghost" :link="route('home')" />
        </div>
      </x-slot:title>

      <!-- Form registrasi -->
      <x-form wire:submit="register" class="space-y-4 pt-4">
        <x-input label="Nama Lengkap" wire:model="name" placeholder="Nama Lengkap" icon="lucide.user-square-2" inline />
        <x-input label="Username" wire:model="username" placeholder="Nama Pengguna" icon="lucide.user-circle-2" inline />
        <x-input label="E-mail" wire:model="email" placeholder="E-mail" icon="lucide.mail" inline />
        <x-password label="Password" wire:model="password" placeholder="Password" password-icon="lucide.lock-keyhole" password-visible-icon="lucide.lock-keyhole-open" inline />

        <x-slot:actions separator>
          <div class="flex justify-between w-full">
            <!-- Tombol ke halaman login -->
            <x-button label="Masuk" icon="lucide.user-circle-2" color="neutral" :link="route('login')" />
            <!-- Tombol submit registrasi -->
            <x-button label="Registrasi" icon="lucide.user-pen" class="btn-primary" type="submit" spinner="register" />
          </div>
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
</div>
