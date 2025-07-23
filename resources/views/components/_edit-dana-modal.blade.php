<div>
  {{-- resources/views/components/edit-dana-modal.blade.php --}}

  @props([
  'wireModel' => 'editModal',
  'submitAction' => 'saveEdit',
  'title' => 'Edit Dana Darurat',
  'types' => [], // array tipe dari controller/Livewire
  ])

  <x-modal :wire:model="$wireModel" :title="$title" subtitle="Ubah data dana darurat kamu.">
    <x-form no-separator>

      <x-input label="Jumlah" wire:model.defer="edit.amount" prefix="IDR" money locale="id-ID" inline />

      <x-select label="Tipe" wire:model.defer="edit.type" :options="$types" icon="o-rocket-launch" inline />

      <x-textarea label="Keterangan" wire:model.defer="edit.description" placeholder="Tulis sesuatu ..." rows="5" inline />

      <x-slot:actions>
        <x-button label="Batal" @click="$wire.{{ $wireModel }} = false" />
        <x-button label="Simpan" icon="lucide.save" class="btn-primary" @click="$wire.{{ $submitAction }}" />
      </x-slot:actions>

    </x-form>
  </x-modal>
</div>
