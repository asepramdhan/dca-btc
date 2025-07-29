<?php

use function Laravel\Folio\name;
 
name('password.reset');

?>

<x-app-layout>
  <div>
    <livewire:reset-password :token="$token" />
  </div>
</x-app-layout>
