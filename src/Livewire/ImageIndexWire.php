<?php

namespace Aweram\Fileable\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ImageIndexWire extends Component
{
    use WithPagination, WithFileUploads;

    public Model $model;
    public array $images = [];
    public array $forUpload = [];
    public bool $uploadProcess = false;

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

    public function updatedImages(): void
    {
        $this->forUpload = [];
        foreach ($this->images as $image) {
            /**
             * @var TemporaryUploadedFile $image
             */
            $clientOriginal = $image->getClientOriginalName();
            $exploded = explode(".", $clientOriginal);
            $this->forUpload[] = [
                "image" => $image,
                "name" => $exploded[0]
            ];
        }
    }

    public function render(): View
    {
        return view("fa::livewire.admin.images");
    }

    public function startUploadImages(): void
    {
        $this->uploadProcess = true;
        $this->dispatch("next-item")->self();
    }

    #[On('next-item')]
    public function uploadImages(): void
    {
        $this->uploadProcess = true;
        $total = count($this->forUpload);
        if ($total <= 0) {
            // TODO: message
            $this->uploadProcess = false;
            $this->reset("images");
            return;
        }
        $item = array_shift($this->forUpload);
        debugbar()->info($item);
        sleep(1);
        // TODO: save and make validation
        $this->dispatch("next-item")->self();
    }

    public function clearSearch(): void
    {
        $this->reset("searchEmail", "searchName");
        $this->resetPage();
    }

    public function deleteImageItem(int $index): void
    {
        if (! empty($this->forUpload[$index])) {
            array_splice($this->forUpload, $index, 1);
        }
    }

    public function showCreate(): void
    {
        $this->resetFields();
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! method_exists($this->model, "livewireGalleryImage")) {
            session()->flash("error", "Gallery does not exist");
            $this->closeData();
            return;
        }

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

