<?php

namespace App\Validator;

use App\Repository\CustomerRepository;
use App\Validator\Constraint\AccessTokenConstraint;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TokenValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AccessTokenConstraint) {
            throw new UnexpectedTypeException($constraint, AccessTokenConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (
            $this->customerRepository
                ->findOneBy(['accessToken' => $value])
        ) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}
