<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace Tests\Utils;

use App\Service\Delivery\DeliveryRequestException;
use App\Service\Delivery\DeliveryRequestValidator;
use PHPUnit\Framework\TestCase;

class DeliveryRequestValidatorTest extends TestCase
{
    private DeliveryRequestValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new DeliveryRequestValidator();
    }

    public function testBadValid()
    {
        $this->expectException(DeliveryRequestException::class);
        $this->validator->validate([]);
    }

    public function testGetErrors()
    {
        try {
            $this->validator->validate([]);
        } catch (DeliveryRequestException $e) {
            $this->assertCount(3, $e->getErrors());
            foreach ($e->getErrors() as $error) {
                $this->assertStringContainsString('This field is missing', $error);
            }
        }
    }

    public function testGetTwoErrors()
    {
        $data = ['sourceKladr' => 'Москва'];

        try {
            $this->validator->validate($data);
        } catch (DeliveryRequestException $e) {
            $errors = $e->getErrors();
            $this->assertCount(2, $errors);

            $this->assertStringContainsString('This field is missing.', $errors['targetKladr']);
            $this->assertStringContainsString('This field is missing.', $errors['weight']);
        }
    }

    public function testBadWeight()
    {
        $data = [
            'sourceKladr' => 'Москва',
            'targetKladr' => 'Владимир',
            'weight' => '1.1',
        ];

        try {
            $this->validator->validate($data);
        } catch (DeliveryRequestException $e) {
            $errors = $e->getErrors();
            $this->assertCount(1, $errors);
            $this->assertStringContainsString('This value should be of type float.', $errors['weight']);
        }
    }

    public function testGoodData()
    {
        $data = [
            'sourceKladr' => 'Москва',
            'targetKladr' => 'Владимир',
            'weight' => 1.24,
        ];

        $result = true;

        try {
            $this->validator->validate($data);
        } catch (DeliveryRequestException $e) {
            $result = false;
        }

        $this->assertTrue($result);
    }

    public function testGoodFastOffer()
    {
        $data = [
            'company_id' => 1,
            'period' => 2,
            'price' => 22.33,
        ];

        $result = true;
        try {
            $this->validator->validateOffer($data);
        } catch (DeliveryRequestException $e) {
            $result = false;
        }
        $this->assertTrue($result);
    }

    public function testBadSlowOffer()
    {
        $data = [
            'company_id' => 1,
            'coefficient' => 2.2,
            'date' => 22.33,
        ];

        $result = true;
        try {
            $this->validator->validateOffer($data);
        } catch (DeliveryRequestException $e) {
            $result = false;
        }
        $this->assertFalse($result);
    }

    public function testBadFastOffer()
    {
        $data = [
            'company_id' => 1,
            'period' => '22',
            'price' => 1,
        ];

        $result = true;
        try {
            $this->validator->validateOffer($data);
        } catch (DeliveryRequestException $e) {
            $result = false;
        }
        $this->assertFalse($result);
    }
}
