<?php

use function Laravel\Folio\name;
 
name('admin.users');

?>

<x-app-layout :title="__('Halaman Users')">
  <div>
    <livewire:users />
  </div>
</x-app-layout>
