<?php

declare(strict_types=1);

namespace App\Brands;

class MoonShine extends Brand
{
    protected array $projects = [
        'moonshine/moonshine',
    ];

    protected array $sections = [
        'require',
        'require-dev',
    ];

    public function isFound(): bool
    {
        return $this->search($this->filesystem->getComposer());
    }
}
