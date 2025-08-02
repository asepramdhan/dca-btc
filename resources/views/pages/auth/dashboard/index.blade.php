<?php

use function Laravel\Folio\name;
 
name('dashboard');

?>

<x-app-layout :title="__('Halaman Dashboard')">
  <div>
    <livewire:dashboard />
  </div>
</x-app-layout>
