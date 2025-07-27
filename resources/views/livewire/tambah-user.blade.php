<div>
  <x-header subtitle="Tambahkan User Baru" separator />
  <div class="lg:w-1/2">
    <!-- User creation form -->
    <x-form>
      <x-input label="Nama Lengkap" wire:model="name" placeholder="Nama Lengkap" icon="lucide.user-square-2" inline autofocus />
      <x-input label="Username" wire:model="username" placeholder="Nama Pengguna" icon="lucide.user-circle-2" inline />
      <x-input label="E-mail" wire:model="email" placeholder="E-mail" icon="lucide.mail" inline />
      <x-password label="Password" wire:model="password" placeholder="Password" password-icon="lucide.lock-keyhole" password-visible-icon="lucide.lock-keyhole-open" inline />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" :link="route('admin.users')" />
        <x-button label="Tambah Lagi" icon="lucide.plus" class="btn-success btn-sm" wire:click="tambahLagi" spinner />
        <x-button label="Tambah" icon="lucide.circle-fading-plus" class="btn-primary btn-sm" wire:click="tambahDanKembali" spinner />
      </x-slot:actions>
    </x-form>
  </div>
</div>
