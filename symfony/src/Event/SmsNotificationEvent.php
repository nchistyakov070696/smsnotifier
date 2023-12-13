<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class SmsNotificationEvent extends Event
{
    public function __construct(
        private readonly int $clientId,
        private readonly string $phoneNumber,
        private readonly string $message,
    ) {
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
