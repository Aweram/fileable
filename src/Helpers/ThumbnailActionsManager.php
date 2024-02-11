<?php

namespace Aweram\Fileable\Helpers;

use Aweram\Fileable\Interfaces\FileModelInterface;
use Aweram\Fileable\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;

class ThumbnailActionsManager
{
    public function findByName(string $fileName): FileModelInterface
    {
        try {
            return $this->getFileModel()::query()
                ->where("path", "like", "%{$fileName}")
                ->firstOrFail();
        } catch (\Exception $ex) {
            abort(404);
        }
    }

    /**
     * @param string $template
     * @param FileModelInterface $file
     * @return string
     */
    public function getFilteredContent(string $template, FileModelInterface $file): string
    {
        $filtered = $this->getFilteredImage($template, $file->id);
        if (! empty($filtered)) return Storage::get($filtered->path);
        else return $this->makeImage($template, $file);
    }

    /**
     * @param string $template
     * @param int $id
     * @return null|FileModelInterface
     */
    protected function getFilteredImage(string $template, int $id): ?FileModelInterface
    {
        $model = $this->getFileModel();
        return $model::query()
            ->where("parent_id", $id)
            ->where("template", $template)
            ->first();
    }

    /**
     * @param string $template
     * @param FileModelInterface $file
     * @return EncodedImageInterface
     */
    protected function makeImage(string $template, FileModelInterface $file): EncodedImageInterface
    {
        $class = $this->getTemplate($template);
        $manager = new ImageManager(config("fileable.driver"));
        $intImage = $manager->read(Storage::get($file->path));
        $newImage = $intImage->modify($class);
        $content = $newImage->toWebp();

        $name = $file->name;
        $mime = "webp";
        $type = "image";
        $parent_id = $file->id;
        $path = "filters/{$template}-{$file->id}-" . Str::random(40);
        Storage::put($path, $content);
        $modelClass = $this->getFileModel();
        $image = $modelClass::create(compact("path", "name", "mime", "type", "template", "parent_id"));
        return $content;
    }

    protected function getTemplate(string $name)
    {
        $template = config("fileable.templates.{$name}");
        switch (true) {
            // closure template found
            case is_callable($template):
                return $template;

            // filter template found
            case class_exists($template):
                return new $template;

            default:
                // template not found
                abort(404);
        }
    }

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed|string
     */
    private function getFileModel(): mixed
    {
        return config("fileable.customFileModel") ?? File::class;
    }
}
