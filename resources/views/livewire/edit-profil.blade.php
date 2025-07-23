  <div class="lg:w-1/2">
    <!-- Profil Fund Form -->
    <x-form wire:submit="updateProfil">
      <!-- Form Inputs -->
      <x-input label="Nama Lengkap" wire:model="name" placeholder="Nama Lengkap" icon="lucide.user-square-2" inline />
      <x-input label="Username" wire:model="username" placeholder="Nama Pengguna" icon="lucide.user-circle-2" inline />
      <x-input label="E-mail" wire:model="email" placeholder="E-mail" icon="lucide.mail" inline />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" :link="route('profil')" />
        <x-button label="Ubah" icon="lucide.edit" class="btn-primary btn-sm" type="submit" spinner="updateProfil" />
      </x-slot:actions>
    </x-form>
  </div>
