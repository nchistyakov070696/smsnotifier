<?php

namespace App\EventHandler;

use App\Event\SmsNotificationEvent;
use App\Service\QueueService;
use App\Service\SmsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async', priority: 10)]
readonly class SmsNotificationEventHandler
{
    public function __construct(
        private QueueService $queueService,
        private SmsService $smsService,
    ) {
    }

    public function __invoke(SmsNotificationEvent $event): void
    {
        try {
            $this->smsService->send(
                $event->getClientId(),
                $event->getPhoneNumber(),
                $event->getMessage()
            );
        } catch (\Exception $e) {
            $this->queueService->pushToQueue($event, true);
        }
    }
}
