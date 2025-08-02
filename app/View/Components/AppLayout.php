<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Properti publik untuk menyimpan judul.
     * Ini akan secara otomatis diisi oleh nilai dari atribut :title
     * saat memanggil komponen di Blade.
     */
    public string $title = '';
    /**
     * Create a new component instance.
     */
    public function __construct(string $title = '')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.app');
    }
}
