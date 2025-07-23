<div>
  @props([
  'wireModel' => 'pinModal',
  'pinModel' => 'pin',
  'title' => 'Konfirmasi Aksi',
  'description' => 'Masukkan PIN Anda untuk melanjutkan.',
  'submitLabel' => 'Konfirmasi',
  'cancelLabel' => 'Batal',
  'submitAction' => 'confirmPin',
  ])

  <x-modal :wire:model="$wireModel" :title="$title" persistent separator>
    <div class="text-center space-y-4">
      <p class="text-gray-600">{{ $description }}</p>
      <div class="flex justify-center">
        <x-pin wire:model="{{ $pinModel }}" size="4" hide numeric autofocus />
      </div>
    </div>

    <x-slot:actions>
      <x-button class="btn-ghost" :link="route('pin')">
        <span class="flex items-center space-x-2">
          <x-icon name="lucide.key" class="w-4 h-4" />
          <span>{{ auth()->user()->pin ? 'PIN sudah diatur, tetapi lupa?' : 'PIN belum diatur' }}</span>
          {{-- <span>{{ auth()->user()->pin ? 'Ubah PIN' : 'Buat PIN Baru' }}</span> --}}
        </span>
      </x-button>
      <x-button label="{{ $cancelLabel }}" @click="$wire.{{ $wireModel }} = false" />
      <x-button label="{{ $submitLabel }}" class="btn-error" wire:click="{{ $submitAction }}" />
    </x-slot:actions>
  </x-modal>

</div>
