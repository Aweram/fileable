<?php

namespace Aweram\Fileable\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ImageIndexWire extends Component
{
    use WithPagination, WithFileUploads;

    public Model $model;
    public TemporaryUploadedFile|null $image = null;
    public string $name = "";

    public string $sortBy = "name";
    public string $sortDirection = "asc";
    public string $searchName = "";

    public bool $displayDelete = false;
    public bool $displayData = false;
    public int|null $imageId = null;

    protected function queryString(): array
    {
        return [
            "sortBy",
            "sortDirection",
            "searchName" => ["as" => "name", "except" => ""],
        ];
    }

    public function rules(): array
    {
        return [
            "name" => ["nullable", "string", "max:50"],
            "image" => ["required", "image"]
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => __("Name"),
            "image" => __("Image")
        ];
    }

    public function render(): View
    {
        return view("fa::livewire.admin.images");
    }

    public function clearSearch(): void
    {
        $this->reset("searchEmail", "searchName");
        $this->resetPage();
    }

    public function showCreate(): void
    {
        $this->resetFields();
        $this->displayData = true;
    }

    public function store(): void
    {
        $this->validate();
        $this->model->livewireGalleryImage($this->image, $this->name);

        session()->flash("success", implode(", ", [
            __("Image successfully added"),
        ]));

        $this->closeData();
        $this->resetPage();
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    private function resetFields(): void
    {
        $this->reset(["name", "imageId", "image"]);
    }
}

