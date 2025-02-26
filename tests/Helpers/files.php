<?php

declare(strict_types=1);

use DragonCode\Support\Facades\Filesystem\Directory;

function fakeComposer(string $path): void
{
    Directory::ensureDirectory($path);

    file_put_contents($path . '/composer.json', json_encode([
        'name' => 'laravel/framework',
    ], JSON_THROW_ON_ERROR));
}
