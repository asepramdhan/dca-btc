<div class="flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <x-card shadow separator>
      <x-slot:title>
        <div class="flex justify-between w-full">
          Masuk
          <!-- Tombol kembali ke halaman utama -->
          <x-button icon="lucide.house" class="btn-circle btn-ghost" link="/" />
        </div>
      </x-slot:title>

      <!-- Form login -->
      <x-form wire:submit="login" class="space-y-4 pt-4">
        <x-input label="Username atau E-mail" wire:model="username" placeholder="Username atau E-mail" icon="lucide.user-circle-2" inline />

        <x-password label="Password" wire:model="password" placeholder="Password" password-icon="lucide.lock-keyhole" password-visible-icon="lucide.lock-keyhole-open" inline />

        <div class="text-right text-sm mt-1">
          <!-- Link lupa password -->
          <a href="{{ route('lupa-password') }}" wire:navigate class="text-blue-600 hover:underline">
            Lupa Password?
          </a>
        </div>

        <x-slot:actions separator>
          <div class="flex justify-between w-full">
            <x-button label="Daftar" icon="lucide.user-pen" color="neutral" link="/guest/register" />
            <x-button label="Masuk" icon="lucide.user-circle-2" class="btn-primary" type="submit" spinner="login" />
          </div>
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
</div>
