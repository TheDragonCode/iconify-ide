<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Commands;

use DragonCode\IconifyIde\Services\ConsoleOutput;
use LaravelZero\Framework\Commands\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;

abstract class Command extends BaseCommand
{
    protected ConsoleOutput $info;

    #[\Override]
    protected function configurePrompts(InputInterface $input): void
    {
        parent::configurePrompts($input);

        $this->info = new ConsoleOutput($this->components);
    }
}
