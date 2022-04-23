<?php

declare(strict_types=1);

namespace WyriHaximus\React\Env\Notifier;

final class EnvVar
{
    public function __construct(
        public readonly string $name,
        public readonly mixed $value,
    ) {
        // Got to love 8.1
    }
}
