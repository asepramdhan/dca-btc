<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Edit Voucher') ">
  <div>
    <livewire:edit-voucher :voucher="$voucher" />
  </div>
</x-app-layout>
