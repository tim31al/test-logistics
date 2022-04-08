<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

use App\Service\Company\CompanyService;
use App\Service\Delivery\DeliveryRequestException;
use App\Service\Delivery\DeliveryRequestValidator;
use App\Service\Delivery\DeliveryService;
use PHPUnit\Framework\TestCase;

class DeliverServiceTest extends TestCase
{
    public function testGetSlowOffersGoodData()
    {
        $stubValidator = $this->createMock(DeliveryRequestValidator::class);
        $stubValidator->method('validate');

        $stubCompanyService = $this->createMock(CompanyService::class);
        $stubCompanyService
            ->method('getSlowOffers')
            ->willReturn(['company_id' => 1]);

        $service = new DeliveryService($stubValidator, $stubCompanyService);
        $data = $service->getSlowOffers([]);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('company_id', $data);
    }

    public function testGetSlowOffersBadData()
    {
        $stubValidator = $this->createMock(DeliveryRequestValidator::class);
        $stubValidator
            ->method('validate')
            ->willThrowException(new DeliveryRequestException(['weight' => 'not null']));

        $stubCompanyService = $this->createMock(CompanyService::class);
        $stubCompanyService
            ->method('getSlowOffers')
            ->willReturn(['company_id' => 1]);

        $service = new DeliveryService($stubValidator, $stubCompanyService);

        $exception = null;
        try {
            $service->getSlowOffers([]);
        } catch (DeliveryRequestException $e) {
            $this->assertSame(['weight' => 'not null'], $e->getErrors());
            $exception = true;
        }

        $this->assertTrue($exception);
    }

    public function testGetFastOffersGoodData()
    {
        $stubValidator = $this->createMock(DeliveryRequestValidator::class);
        $stubValidator->method('validate');

        $stubCompanyService = $this->createMock(CompanyService::class);
        $stubCompanyService
            ->method('getFastOffers')
            ->willReturn(['company_id' => 1]);

        $service = new DeliveryService($stubValidator, $stubCompanyService);
        $data = $service->getFastOffers([]);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('company_id', $data);
    }
}
