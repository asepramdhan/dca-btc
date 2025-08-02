<?php

use function Laravel\Folio\name;
 
// name('admin.chat.show');

?>

<x-app-layout :title="__('Halaman Admin Chat') ">
  <div>
    <x-slot:header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Chat Detail') }}
      </h2>
    </x-slot:header>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg p-6">
          {{-- Pastikan Anda meneruskan instance $conversation ke komponen Livewire --}}
          <livewire:admin.chat.show :conversation="$conversation" />
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
