<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Commands;

use DragonCode\IconifyIde\Ide\Ide;
use DragonCode\IconifyIde\Services\Publisher;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Attribute\AsCommand;

use function config;
use function is_dir;

#[AsCommand('iconify')]
class PublishCommand extends Command
{
    protected $signature = 'iconify {--all : Publishing files in all projects of the current directory. Maximum depth is 3}';

    protected $description = 'Publishes icons to improve project display in IDE';

    public function handle(Publisher $publisher): void
    {
        foreach ($this->ide() as $class) {
            $ide = $this->initializeIde($class);

            $this->components->info($ide->getName());

            if (! $this->hasIde($ide)) {
                $this->components->twoColumnDetail($ide->getName(), $this->status('NOT FOUND', 'comment'));

                continue;
            }

            $published = false;

            foreach ($ide->getBrands() as $brand) {
                if ($published) {
                    $this->components->twoColumnDetail($brand->getName(), $this->status('SKIPPED', 'comment'));

                    continue;
                }

                if (! $brand->isDetected()) {
                    $this->components->twoColumnDetail($brand->getName(), $this->status('NOT FOUND', 'comment'));

                    continue;
                }

                $publisher->publish($ide, $brand);

                $this->components->twoColumnDetail($brand->getName(), $this->status('PUBLISHED', 'info'));

                $published = true;
            }
        }
    }

    protected function hasIde(Ide $ide): bool
    {
        return is_dir('./' . $ide->getDirectoryName());
    }

    protected function initializeIde(string $ide): Ide
    {
        return $this->app->make($ide);
    }

    protected function ide(): array
    {
        return config('data.ide');
    }

    protected function status(string $text, string $style): string
    {
        return "<$style>$text</$style>";
    }
}
