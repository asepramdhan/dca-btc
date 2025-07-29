  <div class="lg:w-1/2">
    <!-- Reset Password Form -->
    <x-form wire:submit="updatePassword">
      <!-- Form Inputs -->
      <x-password label="Password" wire:model="password" placeholder="Password Baru" password-icon="lucide.lock-keyhole" password-visible-icon="lucide.lock-keyhole-open" inline />
      <x-password label="Password Konfirmasi" wire:model="password_confirmation" placeholder="Password Konfirmasi" password-icon="lucide.lock-keyhole" password-visible-icon="lucide.lock-keyhole-open" inline />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Ubah Password" icon="lucide.key" class="btn-primary btn-sm" type="submit" spinner="updatePassword" />
      </x-slot:actions>
    </x-form>
  </div>
