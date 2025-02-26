<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Services;

use DirectoryIterator;
use DragonCode\Support\Facades\Filesystem\Directory;

use function copy;
use function dirname;
use function file_exists;
use function file_get_contents;
use function json_decode;

use const JSON_THROW_ON_ERROR;

class Filesystem
{
    protected array $registry = [];

    public function __construct(
        protected readonly string $directory
    ) {}

    /**
     * @return DirectoryIterator|array<DirectoryIterator>
     */
    public function directory(string $path): DirectoryIterator
    {
        return Directory::all($path);
    }

    public function copy(string $source, string $target): void
    {
        Directory::ensureDirectory(dirname($target));

        copy($source, $this->directory . '/' . $target);
    }

    public function getComposer(): array
    {
        return $this->registry['composer'] ??= $this->load($this->directory . '/composer.json');
    }

    public function getNode(): array
    {
        return $this->registry['node'] ??= $this->load($this->directory . '/package.json');
    }

    protected function load(string $filename): array
    {
        if (! file_exists($filename)) {
            return [];
        }

        return json_decode(file_get_contents($filename), true, 512, JSON_THROW_ON_ERROR);
    }
}
