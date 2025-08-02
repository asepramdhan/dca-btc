<?php

use function Laravel\Folio\name;
 
name('pin');

?>

<x-app-layout :title="__('Halaman Buat Pin')">
  <div>
    <livewire:pin />
  </div>
</x-app-layout>
