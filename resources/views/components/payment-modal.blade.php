<div>
  @props([
  'wireModel' => 'paymentModal',
  'paymentModel' => 'payment',
  'title' => 'Pilih Metode Pembayaran',
  'description' => 'Silahkan pilih metode pembayaran!',
  'submitLabel' => 'Konfirmasi',
  'cancelLabel' => 'Batal',
  ])

  <x-modal :wire:model="$wireModel" :title="$title" persistent separator>

    <x-form>
      <x-menu>
        <x-menu-item wire:click="$set('payment', 'qris')">
          <b>QRIS</b>
        </x-menu-item>
        <x-menu-sub disabled>
          <x-slot:title><b>Transfer Bank</b></x-slot:title>
          <x-menu-item title="Bank Seabank Indonesia" wire:click="$set('payment', 'seabank')" />
          <x-menu-item title="Bank BNI" wire:click="$set('payment', 'bni')" />
          <x-menu-item title="Bank BRI" wire:click="$set('payment', 'bri')" />
          <x-menu-item title="Bank Mandiri" wire:click="$set('payment', 'mandiri')" />
          <x-menu-item title="Bank BCA" wire:click="$set('payment', 'bca')" />
          <x-menu-item title="Bank CIMB Niaga" wire:click="$set('payment', 'cimb')" />
          <x-menu-item title="Bank Permata" wire:click="$set('payment', 'permata')" />
        </x-menu-sub>
      </x-menu>
      <x-slot:actions>
        <x-button label="{{ $cancelLabel }}" @click="$wire.{{ $wireModel }} = false" />
      </x-slot:actions>
    </x-form>

  </x-modal>

</div>
