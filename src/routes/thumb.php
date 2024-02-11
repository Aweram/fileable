<?php

use Illuminate\Support\Facades\Route;
use Aweram\Fileable\Http\Controllers\ThumbnailController;

$controller = config("fileable.customThumbController") ?? ThumbnailController::class;

Route::middleware(["web"])
    ->get("/thumbnail/{template}/{filename}", [$controller, "show"])
    ->name("thumb-img");
