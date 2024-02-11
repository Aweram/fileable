<?php

namespace Aweram\Fileable\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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
            "name" => ["nullable", "string", "min:3", "max:50"],
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

    /**
     * Когда выбраны новые фалы.
     *
     * @return void
     */
    public function updatedImages(): void
    {
        $this->forUpload = [];
        foreach ($this->images as $image) {
            /**
             * @var TemporaryUploadedFile $image
             */
            $clientOriginal = $image->getClientOriginalName();
            $exploded = explode(".", $clientOriginal);
            try {
                $previewUrl = $image->temporaryUrl();
            } catch (\Exception $e) {
                $previewUrl = null;
            }
            $this->forUpload[] = [
                "image" => $image,
                "preview" => $previewUrl,
                "name" => $exploded[0]
            ];
        }
    }

    public function render(): View
    {
        $query = $this->model->images();
        /**
         * @var Builder $query
         */
        if (! empty($this->searchName)) {
            $value = trim($this->searchName);
            $query->where("name", "like", "%$value%");
        }
        $query->orderBy($this->sortBy, $this->sortDirection);

        return view("fa::livewire.admin.images", [
            "gallery" => $query->get()
        ]);
    }

    public function clearSearch(): void
    {
        $this->reset("searchName");
        $this->resetPage();
    }

    public function changeSort(string $name): void
    {
        if ($this->sortBy == $name) {
            $this->sortDirection = $this->sortDirection == "asc" ? "desc" : "asc";
        } else $this->sortDirection = "asc";
        $this->sortBy = $name;
        $this->resetPage();
    }

    /**
     * Начать загрузку файлов.
     *
     * @return void
     */
    public function startUploadImages(): void
    {
        $this->uploadProcess = true;
        $this->dispatch("next-item")->self();
    }

    /**
     * Загрузка фалов по одному.
     *
     * @return void
     */
    #[On('next-item')]
    public function uploadImages(): void
    {
        if (! method_exists($this->model, "livewireGalleryImage")) {
            session()->flash("error", "Gallery does not exist");
            return;
        }
        // Проверка на то, что еще остались файлы.
        $this->uploadProcess = true;
        $total = count($this->forUpload);
        if ($total <= 0) {
            session()->flash("success", implode(", ", [
                __("Image sequence successfully added"),
            ]));
            $this->uploadProcess = false;
            $this->reset("images");
            return;
        }
        // Получение файла и его имени.
        $item = $this->forUpload[0];
        $this->image = $item["image"];
        $this->name = $item["name"];
        // Валидация и загрузка файла.
        $this->uploadProcess = false;
        $this->validate();
        $this->uploadProcess = true;
        array_shift($this->forUpload);
        $this->model->livewireGalleryImage($this->image, $this->name);
        $this->reset("name", "image");
        $this->dispatch("next-item")->self();
    }

    /**
     * Удалить файл из последовательности.
     * @param int $index
     * @return void
     */
    public function deleteImageItem(int $index): void
    {
        if (! empty($this->forUpload[$index])) {
            array_splice($this->forUpload, $index, 1);
            $this->reset("name", "image");
            $this->resetValidation();
        }
    }

    public function showDelete(int $imageId): void
    {
        $this->reset("imageId");
        $this->imageId = $imageId;
        $this->displayDelete = true;
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->reset("imageId");
    }

    public function confirmDelete(): void
    {
        try {
            $image = $this->model->gallery_file_class::find($this->imageId);
            $image->delete();
            session()->flash("success", __("Image successfully deleted"));
        } catch (\Exception $ex) {
            session()->flash("error", __("Image not found"));
        }
        $this->resetPage();
        $this->closeDelete();
    }

    private function resetFields(): void
    {
        $this->reset(["name", "imageId", "image"]);
    }
}

