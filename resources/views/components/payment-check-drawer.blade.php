<div>
  @props([
  'wireModel' => 'paymentCheckDrawer',
  'paymentModel' => 'payment',
  'title' => 'Pilih Metode Pembayaran',
  'description' => 'Silahkan pilih metode pembayaran!',
  'submitLabel' => 'Konfirmasi',
  'cancelLabel' => 'Batal',
  'rejectLabel' => 'Tolak',
  'submitAction' => 'confirmPayment',
  'cancelAction' => 'rejectPayment',
  'item' => 'transaction',
  ])

  {{-- Left --}}
  <x-drawer :wire:model="$wireModel" :title="$title" class="w-11/12 lg:w-1/3">
    <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm mb-4">
      <x-list-item :item="$item">
        <x-slot:sub-value>
          {{ $slot }}
        </x-slot:sub-value>
      </x-list-item>
    </div>
    <x-button label="Close" @click="$wire.{{ $wireModel }} = false" />
    <x-button label="{{ $rejectLabel }}" class="btn-error" wire:click="{{ $cancelAction }}" spinner="{{ $cancelAction }}" />
    <x-button label="{{ $submitLabel }}" class="btn-primary" wire:click="{{ $submitAction }}" spinner="{{ $submitAction }}" />
  </x-drawer>
</div>
