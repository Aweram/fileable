<?php

return [
    "customFileModel" => null,
    "customFileObserver" => null,
    "customImageIndexComponent" => null,
    "customThumbController" => null,
    'lifetime' => 43200,
    "driver" => \Intervention\Image\Drivers\Imagick\Driver::class,
    "templates" => [
        "gallery-preview" => \Aweram\Fileable\Templates\GalleyPreview::class,
        "small" => \Aweram\Fileable\Templates\Small::class
    ]
];
