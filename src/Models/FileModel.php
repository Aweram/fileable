<?php

namespace Aweram\Fileable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class FileModel extends Model
{
    use HasFactory;

    protected $fillable = [
        "path",
        "name",
        "mime",
        "priority",
        "type",
        "parent_id",
        "template",
    ];

    /**
     * @return MorphTo
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return HasMany
     */
    public function thumbnails(): HasMany
    {
        $modelClass = config("fileable.customFileModel") ?? $this::class;
        return $this->hasMany($modelClass, "parent_id");
    }

    /**
     * @return string
     */
    public function getStorageAttribute(): string
    {
        return Storage::url($this->path);
    }

    /**
     * @return string
     */
    public function getFileNameAttribute(): string
    {
        $exploded = explode("/", $this->path);
        return $exploded[count($exploded) - 1];
    }
}
