<?php

declare(strict_types=1);

namespace WyriHaximus\React\Env\Notifier;

/** @api */
final readonly class EnvVar
{
    public function __construct(
        public string $name,
        public mixed $value,
    ) {
        // Got to love 8.1
    }
}
