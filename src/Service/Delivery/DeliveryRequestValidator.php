<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Service\Delivery;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeliveryRequestValidator
{
    private ValidatorInterface $validator;
    private Collection $constraint;

    public function __construct()
    {
        $kladrRules = [
            new Assert\Regex('/^[А-я ]+$/u'),
            new Assert\Length(['max' => 100]),
        ];

        $this->validator = Validation::createValidator();
        $this->constraint = new Assert\Collection([
            'sourceKladr' => $kladrRules,
            'targetKladr' => $kladrRules,
            'weight' => new Assert\Type('float'),
        ]);
    }

    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    public function validate(array $data)
    {
        $violations = $this->validator->validate($data, $this->constraint);

        if (0 !== \count($violations)) {
            $this->setErrors($violations);
        }
    }

    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    public function validateOffer(array $data)
    {
        if (isset($data['date'])) {
            $violations = $this->validateSlowOffer($data);
        } elseif (isset($data['period'])) {
            $violations = $this->validateFastOffer($data);
        } else {
            throw new DeliveryRequestException(['error' => 'bad data']);
        }

        if (0 !== \count($violations)) {
            $this->setErrors($violations);
        }
    }

    private function validateFastOffer(array $data): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection([
            'company_id' => new Assert\Type('integer'),
            'price' => new Assert\Type('float'),
            'period' => new Assert\Type('integer'),
        ]);

        return $this->validator->validate($data, $constraint);
    }

    private function validateSlowOffer(array $data): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection([
            'company_id' => new Assert\Type('integer'),
            'coefficient' => new Assert\Type('float'),
            'date' => new Assert\Date(),
        ]);

        return $this->validator->validate($data, $constraint);
    }

    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    private function setErrors(ConstraintViolationListInterface $violations)
    {
        $errors = [];
        foreach ($violations as $violation) {
            $key = str_replace(['[', ']'], '', $violation->getPropertyPath());
            $errors[$key] = $violation->getMessage();
        }

        throw new DeliveryRequestException($errors);
    }
}
