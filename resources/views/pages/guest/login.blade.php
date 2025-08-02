<?php

use function Laravel\Folio\name;
 
name('login');

?>

<x-app-layout :title="__('Halaman Login')">
  <div>
    <livewire:login />
  </div>
</x-app-layout>
