<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Services;

use function copy;
use function file_exists;
use function file_get_contents;
use function json_decode;

use const JSON_THROW_ON_ERROR;

class Filesystem
{
    protected array $registry = [];

    public function copy(string $source, string $target): void
    {
        copy($source, $target);
    }

    public function getComposer(): array
    {
        return $this->registry['composer'] ??= $this->load('composer.json');
    }

    protected function load(string $filename): array
    {
        if (! file_exists($filename)) {
            return [];
        }

        return json_decode(file_get_contents($filename), true, 512, JSON_THROW_ON_ERROR);
    }
}
