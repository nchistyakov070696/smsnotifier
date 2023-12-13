<?php

namespace App\Event\EventBuilder;

use App\DTO\SmsDTO;
use App\Entity\Customer;
use App\Event\SmsNotificationEvent;
use App\Repository\CustomerRepository;

readonly class SmsNotificationEventBuilder
{
    public function __construct(
        private CustomerRepository $customerRepository,
    ) {
    }

    public function buildEvent(SmsDTO $smsDTO): SmsNotificationEvent|null
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->findOneBy([
            'accessToken' => $smsDTO->accessToken,
        ]);

        if (!$customer) {
            return null;
        }

        return new SmsNotificationEvent(
            $customer->getId(),
            $smsDTO->phoneNumber,
            $smsDTO->message
        );
    }
}
