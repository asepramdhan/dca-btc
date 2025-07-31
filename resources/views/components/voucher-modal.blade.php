<div>
  @props([
  'wireModel' => 'voucherModal',
  'voucherModel' => 'voucher',
  'title' => 'Masukan Voucher',
  'description' => 'Masukan voucher dan upgrade sekarang!',
  'submitLabel' => 'Konfirmasi',
  'cancelLabel' => 'Batal',
  'submitAction' => 'confirmVoucher',
  ])

  <x-modal :wire:model="$wireModel" :title="$title" persistent separator>

    <x-form wire:submit="{{ $submitAction }}" no-separator>
      <x-input label="Masukan Kode Voucher" wire:model="{{ $voucherModel }}" icon="lucide.ticket" placeholder="Masukan Kode Voucher" inline />

      {{-- Notice we are using now the `actions` slot from `x-form`, not from modal --}}
      <x-slot:actions>
        <x-button label="{{ $cancelLabel }}" @click="$wire.{{ $wireModel }} = false" />
        <x-button label="{{ $submitLabel }}" class="btn-primary" type="submit" spinner="{{ $submitAction }}" />
      </x-slot:actions>
    </x-form>

  </x-modal>

</div>
