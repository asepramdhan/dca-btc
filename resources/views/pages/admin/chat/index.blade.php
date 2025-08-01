<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout>
  <div>
    <x-slot:header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Chat Overview') }}
      </h2>
    </x-slot:header>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg p-6">
          <livewire:admin.chat.index />
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
