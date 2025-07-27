<div>
  <x-header subtitle="Edit User" separator />
  <div class="lg:w-1/2">
    <!-- User edit form -->
    <x-form wire:submit="updateUser">
      <x-input label="Nama Lengkap" wire:model="name" placeholder="Nama Lengkap" icon="lucide.user-square-2" inline autofocus />
      <x-input label=" Username" wire:model="username" placeholder="Nama Pengguna" icon="lucide.user-circle-2" inline />
      <x-input label="E-mail" wire:model="email" placeholder="E-mail" icon="lucide.mail" inline />
      <x-checkbox label="Admin" wire:model="is_admin" />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/admin/users" />
        <x-button label="Ubah" icon="lucide.edit" class="btn-primary btn-sm" type="submit" spinner="updateUser" />
      </x-slot:actions>
    </x-form>
  </div>
</div>
