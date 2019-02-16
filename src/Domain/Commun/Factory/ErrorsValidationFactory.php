<?php

namespace App\Domain\Commun\Factory;

use App\Domain\Commun\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorsValidationFactory
{
    public static function buildError(ConstraintViolationListInterface $constraintViolationList)
    {
        if (count($constraintViolationList) > 0) {
            $errors = [];
            /** @var ConstraintViolationInterface $constraint */
            foreach ($constraintViolationList as $constraint) {
                $errors[$constraint->getPropertyPath()][] = $constraint->getMessage();
            }
            //TODO Custom exception
            throw new ValidatorException(
                Response::HTTP_BAD_REQUEST,
                $errors
            );
        }
    }
}