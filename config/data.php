<?php

use App\Brands\Laravel;
use App\Brands\MoonShine;
use App\Ide\Fleet;
use App\Ide\PhpStorm;

return [
    'ide' => [
        PhpStorm::class,
        Fleet::class,
    ],

    'brands' => [
        Laravel::class,
        MoonShine::class,
    ],
];
