<?php

namespace App\DTO;

use App\Validator;
use Symfony\Component\Validator\Constraints as Assert;

class SmsDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'accessToken: not passed')]
        #[Assert\Length(min: 8, max: 255, minMessage: 'accessToken: min 8', maxMessage: 'accessToken: max 255')]
        #[Validator\Constraint\AccessTokenConstraint]
        public string $accessToken,

        #[Assert\NotBlank(message: 'phoneNumber: not passed')]
        #[Assert\Regex('/^\+375\(\d{2}\)\d{7}$/', message: 'phoneNumber: wrong format')]
        public string $phoneNumber,

        #[Assert\NotBlank(message: 'message: not passed')]
        #[Assert\Length(min: 1, max: 255, minMessage: 'message: min 1', maxMessage: 'message: max 255')]
        public string $message,
    ) {
    }
}
