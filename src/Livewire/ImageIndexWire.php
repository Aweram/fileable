<?php

namespace Aweram\Fileable\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ImageIndexWire extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view("fa::livewire.admin.images");
    }
}
