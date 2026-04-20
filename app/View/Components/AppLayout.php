<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return view('layouts.admin');
        }

        return view('layouts.app');
    }
}
