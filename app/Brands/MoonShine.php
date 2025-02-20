<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Brands;

class MoonShine extends Brand
{
    protected ?string $name = 'MoonShine';

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
