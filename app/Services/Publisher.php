<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Services;

use DragonCode\IconifyIde\Brands\Brand;
use DragonCode\IconifyIde\Ide\Ide;

class Publisher
{
    public function __construct(
        protected Filesystem $files
    ) {}

    public function publish(Ide $ide, Brand $brand): void
    {
        $this->files->copy(
            $this->sourcePath($brand),
            $this->targetPath($ide)
        );
    }

    protected function sourcePath(Brand $brand): string
    {
        return __DIR__ . '/../../resources/brands/' . $brand->getFilename() . '.svg';
    }

    protected function targetPath(Ide $ide): string
    {
        return $ide->getDirectoryName() . '/' . $ide->getFilename();
    }
}
