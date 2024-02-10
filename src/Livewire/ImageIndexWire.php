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
        return view("fa::livewire.admin.images");
    }

    public function clearSearch(): void
    {
        $this->reset("searchEmail", "searchName");
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

    private function resetFields(): void
    {
        $this->reset(["name", "imageId", "image"]);
    }
}

