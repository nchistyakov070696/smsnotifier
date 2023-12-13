<?php

namespace App\Validator\Constraint;

use App\Validator\TokenValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class AccessTokenConstraint extends Constraint
{
    public string $message = 'accessToken: not allowed';
    public string $mode = 'strict';

    public function __construct(string $mode = null, string $message = null, array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string
    {
        return TokenValidator::class;
    }
}
