<?php

declare(strict_types=1);

use DragonCode\IconifyIde\Commands\Command;
use Symfony\Component\Console\Attribute\AsCommand;

arch()->expect('App\Commands')
    ->toHaveSuffix('Command');

arch()->expect('App\Commands')
    ->toHaveAttribute(AsCommand::class)
    ->ignoring(Command::class);
