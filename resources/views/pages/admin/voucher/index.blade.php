<?php

use function Laravel\Folio\name;
 
name('admin.voucher');

?>

<x-app-layout :title="__('Halaman Voucher') ">
  <div>
    <livewire:admin-voucher />
  </div>
</x-app-layout>
