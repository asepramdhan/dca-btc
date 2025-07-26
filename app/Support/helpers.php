<?php

if (!function_exists('breadcrumbs')) {
  function breadcrumbs(): array
  {
    $skipSegments = ['auth', 'guest', 'admin']; // folder teknis
    $segments = request()->segments();
    $breadcrumbs[] = [
      'icon' => 'lucide.layout-dashboard',
      'link' => url('/auth/dashboard'), // dashboard
    ];

    $fullPath = '';
    $breadcrumbsPath = [];

    foreach ($segments as $segment) {
      $fullPath .= '/' . $segment;

      if (in_array($segment, $skipSegments)) {
        continue; // Skip hanya untuk label
      }

      $breadcrumbs[] = [
        'label' => ucwords(str_replace('-', ' ', $segment)),
        'link' => url($fullPath),
      ];
    }

    // Hapus link terakhir (halaman aktif)
    $last = array_key_last($breadcrumbs);
    unset($breadcrumbs[$last]['link']);

    return $breadcrumbs;
  }
}
