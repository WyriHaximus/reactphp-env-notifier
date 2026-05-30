<?php

declare(strict_types=1);

namespace WyriHaximus\React\Env\Notifier;

use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;
use Rx\Subject\Subject;

use function getenv;
use function WyriHaximus\React\awaitObservable;

/** @api */
final class Notifier
{
    private const int CHECK_INTERVAL = 1;

    /** @return iterable<EnvVar> */
    public static function listen(string $name): iterable
    {
        $currentValue = getenv($name);
        $stream       = new Subject();

        Loop::addPeriodicTimer(self::CHECK_INTERVAL, static function (TimerInterface $timer) use ($stream, $name, &$currentValue): void {
            if ($stream->isDisposed()) {
                Loop::cancelTimer($timer);

                return;
            }

            $latestValue = getenv($name);
            if ($currentValue !== $latestValue) {
                $stream->onNext(new EnvVar($name, $latestValue));
            }

            $currentValue = $latestValue;
        });

        /** @phpstan-ignore return.type */
        return awaitObservable($stream);
    }
}
