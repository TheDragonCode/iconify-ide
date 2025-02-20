<?php

use DragonCode\IconifyIde\Brands\LaravelFramework;
use DragonCode\IconifyIde\Brands\LaravelZero;
use DragonCode\IconifyIde\Brands\MoonShine;
use DragonCode\IconifyIde\Ide\Fleet;
use DragonCode\IconifyIde\Ide\PhpStorm;

return [
    'ide' => [
        PhpStorm::class,
        Fleet::class,
    ],

    'brands' => [
        LaravelFramework::class,
        LaravelZero::class,
        MoonShine::class,
    ],
];
