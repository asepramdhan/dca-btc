<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Edit User') ">
  <div>
    <livewire:edit-user :user="$user" />
  </div>
</x-app-layout>
