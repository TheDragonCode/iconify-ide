<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Ide;

use DragonCode\IconifyIde\Brands\Brand;
use DragonCode\IconifyIde\Helpers\Init;
use Illuminate\Support\Str;

use function config;

abstract class Ide
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

    /**
     * @return Brand[]
     */
    public function getBrands(): array
    {
        return Init::classes(config('data.brands'));
    }
}
