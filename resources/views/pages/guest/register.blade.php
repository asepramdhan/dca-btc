<?php

use function Laravel\Folio\name;
 
name('register');

?>

<x-app-layout :title="__('Halaman Register')">
  <div>
    <livewire:register />
  </div>
</x-app-layout>
