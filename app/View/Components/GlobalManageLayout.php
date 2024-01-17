<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

class GlobalManageLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.global-manage');
    }
}
