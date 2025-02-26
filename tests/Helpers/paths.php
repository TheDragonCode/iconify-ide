<?php

declare(strict_types=1);

use DragonCode\Support\Facades\Filesystem\Directory;

function tempDirectory(string $path = ''): string
{
    return __DIR__ . '/../temp/' . $path;
}

function ensureTempDirectory(string $path = ''): void
{
    Directory::ensureDirectory(tempDirectory($path));
}

function refreshTempDirectory(string $path = ''): void
{
    Directory::ensureDelete(tempDirectory($path));
    Directory::ensureDirectory(tempDirectory($path));
}
