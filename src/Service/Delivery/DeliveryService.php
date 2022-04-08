<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Service\Delivery;

use App\Service\Company\CompanyServiceInterface;

class DeliveryService implements DeliveryServiceInterface
{
    private DeliveryRequestValidator $validator;
    private CompanyServiceInterface $companyService;

    public function __construct(DeliveryRequestValidator $validator, CompanyServiceInterface $companyService)
    {
        $this->validator = $validator;
        $this->companyService = $companyService;
    }

    public function getSlowOffers(array $data): array
    {
        $this->validator->validate($data);

        return $this->companyService->getSlowOffers($data);
    }

    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    public function getFastOffers(array $data): array
    {
        $this->validator->validate($data);

        return $this->companyService->getFastOffers($data);
    }

    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    public function getOffer(array $data): array
    {
        $this->validator->validateOffer($data);

        return $this->companyService->getOffer($data);
    }
}
