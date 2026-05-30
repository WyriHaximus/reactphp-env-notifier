<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\Env\Notifier;

use PHPUnit\Framework\Attributes\Test;
use React\EventLoop\Loop;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\AwaitingIterator;
use WyriHaximus\React\Env\Notifier\Notifier;

use function bin2hex;
use function putenv;
use function random_bytes;
use function strtoupper;

final class NotifierTest extends AsyncTestCase
{
    #[Test]
    public function listen(): void
    {
        $oldValue = bin2hex(random_bytes(13));
        $newValue = bin2hex(random_bytes(13));
        $name     = 'WHRPEN_' . strtoupper(bin2hex(random_bytes(13)));
        putenv($name . '=' . $oldValue);

        Loop::addTimer(0.5, static function () use ($name, $newValue): void {
            putenv($name . '=' . $newValue);
        });

        Loop::addTimer(1.1, static function () use ($name): void {
            putenv($name . '=shouldnotreachourstream');
        });

        $took   = 0;
        $stream = Notifier::listen($name);
        foreach ($stream as $envVar) {
            $took++;
            self::assertSame($newValue, $envVar->value);
            if (! ($stream instanceof AwaitingIterator)) {
                continue;
            }

            $stream->break();
        }

        self::assertSame(1, $took);
    }
}
