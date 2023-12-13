<?php

namespace App\Service;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Contracts\EventDispatcher\Event;

readonly class QueueService // todo is it a service? rename and move
{
    private const DELAY_STAMP = 120000; // 120 seconds

    public function __construct(
        private MessageBusInterface $bus,
    ) {
    }

    public function pushToQueue(Event $event, bool $withDelay = false): void
    {
        $this->bus->dispatch($event, $withDelay
            ? [new DelayStamp(self::DELAY_STAMP)]
            : []
        );
    }
}
