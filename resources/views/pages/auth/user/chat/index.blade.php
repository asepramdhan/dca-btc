<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Chat') ">
  <div>
    <x-slot:header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chat dengan Admin') }}
      </h2>
    </x-slot:header>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg p-6">
          {{-- Untuk user, kita tidak perlu meneruskan parameter conversation --}}
          {{-- Karena komponen User.Chat.Show akan otomatis mencari/membuatnya --}}
          <livewire:user.chat.show />
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
