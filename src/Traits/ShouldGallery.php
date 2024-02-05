<?php

namespace Aweram\Fileable\Traits;

use Aweram\Fileable\Models\FileModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait ShouldGallery
{
    protected static function bootShouldGallery()
    {
        statis::deleting(function (Model $model) {
            $model->clearImages();
        });
    }

    /**
     * @return string
     */
    public function getGalleryFileClassAttribute(): string
    {
        return config("fileable.customFileModel") ?? FileModel::class;
    }

    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany($this->gallery_file_class, "fileable");
    }

    /**
     * @return MorphOne
     */
    public function cover(): MorphOne
    {
        return $this->morphOne($this->gallery_file_class, "fileable")->oldest("priority");
    }

    public function clearImages(): void
    {
        foreach ($this->images as $image) {
            $image->delete();
        }
    }
}
