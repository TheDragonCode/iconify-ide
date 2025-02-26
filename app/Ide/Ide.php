<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Ide;

use DragonCode\IconifyIde\Contracts\Named;
use Illuminate\Support\Str;

use function config;

abstract class Ide implements Named
{
    protected string $folder;

    protected string $filename = 'icon.svg';

    public function getName(): string
    {
        return Str::of(static::class)->classBasename()->toString();
    }

    public function getDirectoryName(): string
    {
        return $this->folder;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getBrands(): array
    {
        return config('data.brands');
    }
}
