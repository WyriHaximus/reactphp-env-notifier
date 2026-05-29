<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\React\Env\Notifier;

use PHPUnit\Framework\Attributes\Test;
use React\EventLoop\Loop;
use Rx\Subject\Subject;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\Env\Notifier\EnvVar;
use WyriHaximus\React\Env\Notifier\Notifier;

use function assert;
use function bin2hex;
use function random_bytes;
use function React\Async\await;
use function Safe\putenv;
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

        $stream = Notifier::listen($name);
        self::assertInstanceOf(Subject::class, $stream);
        $envVar = await($stream->take(1)->toPromise());
        assert($envVar instanceof EnvVar);

        $stream->dispose();

        self::assertSame($newValue, $envVar->value);
    }

    #[Test]
    public function dispose(): void
    {
        $stream = Notifier::listen(bin2hex(random_bytes(13)));
        self::assertInstanceOf(Subject::class, $stream);

        Loop::addTimer(0.5, static function () use ($stream): void {
            $stream->dispose();
        });

        Loop::run();

        self::assertTrue($stream->isDisposed());
    }
}
