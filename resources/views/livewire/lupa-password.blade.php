<div class="flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <x-card shadow separator>
      <x-slot:title>
        Lupa Password
      </x-slot:title>

      <!-- Form lupa password -->
      <x-form wire:submit="lupaPassword" class="space-y-4 pt-4">
        <x-input label="E-mail" wire:model="email" placeholder="Masukkan E-mail Terdaftar" icon="lucide.user-circle-2" inline />
        <x-slot:actions separator>
          <div class="flex justify-between w-full">
            <x-button label="Kembali" icon="lucide.chevron-left" color="neutral" link="/guest/login" />
            <x-button label="Kirim" icon="lucide.send" class="btn-primary" type="submit" spinner="lupaPassword" />
          </div>
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
</div>
