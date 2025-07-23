<div>
  @props([
  'wireModel', // Binding state modal-nya
  'title' => 'Konfirmasi',
  'description' => 'Apakah kamu yakin ingin menghapus data ini?',
  'submitLabel' => 'Hapus',
  'submitAction' => null,
  ])

  <x-modal :wire:model="$wireModel" :title="$title" separator>
    <div class="text-center space-y-2">
      <p class="text-gray-600">{{ $description }}</p>
    </div>

    <x-slot:actions>
      <x-button label="Batal" @click="$wire.{{ $wireModel }} = false" />
      <x-button label="{{ $submitLabel }}" icon="lucide.trash-2" class="btn-error" @click="$wire.{{ $submitAction }}" />
    </x-slot:actions>
  </x-modal>
</div>
