<?php

declare(strict_types=1);

namespace DragonCode\IconifyIde\Helpers;

use function array_map;

class Init
{
    public static function classes(array $classes): array
    {
        return array_map(static fn (string $class) => new $class(), $classes);
    }
}
