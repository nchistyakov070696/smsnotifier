<?php

namespace App\Processor;

use App\DTO\SmsDTO;
use App\Event\EventBuilder\SmsNotificationEventBuilder;
use App\Service\QueueService;

readonly class SmsNotificationProcessor
{
    public function __construct(
        private QueueService $queueService,
        private SmsNotificationEventBuilder $eventBuilder
    ) {
    }

    public function handle(SmsDTO $smsDTO): void
    {
        $smsNotificationEvent = $this->eventBuilder->buildEvent($smsDTO);
        $this->queueService->pushToQueue($smsNotificationEvent);
    }
}
