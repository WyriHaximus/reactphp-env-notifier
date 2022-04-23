<?php

declare(strict_types=1);

namespace WyriHaximus\React\Env\Notifier;

use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;
use Rx\Observable;
use Rx\Subject\Subject;

use function getenv;

final class Notifier
{
    private const CHECK_INTERVAL = 1;

    public static function listen(string $name): Observable
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

        return $stream;
    }
}
