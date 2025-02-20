<?php

declare(strict_types=1);

namespace App\Ide;

use App\Brands\Brand;
use App\Brands\Laravel;
use App\Helpers\Init;
use Illuminate\Support\Str;

abstract class Ide
{
    protected string $folder;

    protected string $filename = 'icon.svg';

    /** @var list<class-string<Brand>> */
    protected array $brands = [
        Laravel::class,
    ];

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
        return Init::classes($this->brands);
    }
}
