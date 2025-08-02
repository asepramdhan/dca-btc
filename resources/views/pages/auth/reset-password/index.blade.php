<?php

use function Laravel\Folio\name;
 
name('reset-password');

?>

<x-app-layout :title="__('Halaman Reset Password')">
  <div>
    <livewire:auth-reset-password />
  </div>
</x-app-layout>
