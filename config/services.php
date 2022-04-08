<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

use App\Service\Company\CompanyService;
use App\Service\Company\CompanyServiceInterface;
use App\Service\Delivery\DeliveryRequestValidator;
use App\Service\Delivery\DeliveryService;
use App\Service\Delivery\DeliveryServiceInterface;
use Psr\Container\ContainerInterface;

return [
    DeliveryRequestValidator::class => function (): DeliveryRequestValidator {
        return new DeliveryRequestValidator();
    },

    CompanyServiceInterface::class => function (): CompanyServiceInterface {
        return new CompanyService();
    },

    DeliveryServiceInterface::class => function (ContainerInterface $container): DeliveryServiceInterface {
        $validator = $container->get(DeliveryRequestValidator::class);
        $companyService = $container->get(CompanyServiceInterface::class);

        return new DeliveryService($validator, $companyService);
    },
];
