<?php

namespace Aweram\Fileable\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;

class ImageIndexWire extends Component
{
    use WithPagination;

    public Model $model;

    public function render(): View
    {
        return view("fa::livewire.admin.images");
    }
}
