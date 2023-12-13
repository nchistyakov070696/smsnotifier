<?php

namespace App\DTO;

use App\Validator;
use Symfony\Component\Validator\Constraints as Assert;

class StatisticsDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'accessToken: not passed')]
        #[Assert\Length(min: 8, max: 255, minMessage: 'accessToken: min 8', maxMessage: 'accessToken: max 255')]
        #[Validator\Constraint\AccessTokenConstraint]
        public string $accessToken,

        #[Assert\NotBlank(message: 'dateFrom: not passed')]
        #[Assert\DateTime(message: 'dateFrom: wrong format')]
        #[Assert\LessThanOrEqual(
            propertyPath: 'dateTo',
            message: 'dateFrom: should be less than or equal to dateTo'
        )]
        public string $dateFrom,

        #[Assert\NotBlank(message: 'dateTo: not passed')]
        #[Assert\DateTime(message: 'dateTo: wrong format')]
        public string $dateTo,
    ) {
    }
}
