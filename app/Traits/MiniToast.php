<?php

namespace App\Traits;

trait MiniToast
{
  public function miniToast(
    string $title,
    string $type = 'success',
    string $icon = null,
    int $timeout = 2000,
    string $redirectTo = null
  ): void {
    $this->dispatch('custom-toast', [
      'title' => $title,
      'type' => $type,
      'icon' => $icon ?? $this->getDefaultIcon($type),
      'timeout' => $timeout,
      'redirectTo' => $redirectTo,
    ]);
  }

  private function getDefaultIcon(string $type): string
  {
    return match ($type) {
      'success' => 'lucide.check-circle',
      'error'   => 'lucide.x-circle',
      'warning' => 'lucide.alert-triangle',
      'info'    => 'lucide.info',
      default   => 'lucide.info',
    };
  }
}
