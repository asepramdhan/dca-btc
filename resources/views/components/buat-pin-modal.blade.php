<div>
  @props([
  'wireModel' => 'pinModal',
  'pinModel' => 'pin',
  'title' => 'Buat PIN Baru',
  'description' => 'Silakan masukkan PIN baru Anda.',
  'submitLabel' => 'Simpan',
  'cancelLabel' => 'Batal',
  'submitAction' => 'storePin',
  ])
  <x-modal :wire:model="$wireModel" :title="auth()->user()->pin ? 'Ubah PIN' : $title" persistent separator>
    <div class="text-center space-y-4">
      <p class="text-gray-600">{{ $description }}</p>
      <div class="flex justify-center">
        <x-pin wire:model="{{ $pinModel }}" size="4" hide numeric autofocus />
      </div>
    </div>

    <x-slot:actions>
      <x-button label="{{ $cancelLabel }}" @click="$wire.{{ $wireModel }} = false" />
      <x-button label="{{ $submitLabel }}" icon="lucide.key" class="btn-primary" wire:click="{{ $submitAction }}" />
    </x-slot:actions>
  </x-modal>
</div>
