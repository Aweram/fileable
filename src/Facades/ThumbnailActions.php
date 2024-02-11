<?php

namespace Aweram\Fileable\Facades;

use Aweram\Fileable\Helpers\ThumbnailActionsManager;
use Aweram\Fileable\Interfaces\FileModelInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static FileModelInterface findByName(string $fileName)
 * @method static mixed|string getFilteredContent(string $template, FileModelInterface $file)
 *
 * @see ThumbnailActionsManager
 */
class ThumbnailActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "thumbnail-actions";
    }
}
