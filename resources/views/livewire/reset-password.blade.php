<div class="flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <x-card shadow separator>
      <x-slot:title>
        Reset Password
      </x-slot:title>

      <!-- Form reset password -->
      <x-form wire:submit="resetPassword" class="space-y-4 pt-4">
        <x-input label="E-mail" wire:model="email" placeholder="Masukkan E-mail Terdaftar" icon="lucide.user-circle-2" inline />
        <x-password label="Password" wire:model="password" placeholder="Password" password-icon="lucide.lock-keyhole" password-visible-icon="lucide.lock-keyhole-open" inline />
        <x-password label="Password Konfirmasi" wire:model="password_confirmation" placeholder="Password Konfirmasi" password-icon="lucide.lock-keyhole" password-visible-icon="lucide.lock-keyhole-open" inline />
        <x-slot:actions separator>
          <div class="flex justify-between w-full">
            <x-button label="Konfirmasi Ubah Password" icon="lucide.user-circle-2" class="btn-primary" type="submit" spinner="resetPassword" />
          </div>
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
</div>
