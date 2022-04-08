<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Controller\Delivery;

use App\Controller\JsonResponseTrait;
use App\Service\Delivery\DeliveryServiceInterface;

abstract class DeliverAbstractController
{
    use JsonResponseTrait;

    protected DeliveryServiceInterface $deliveryService;

    public function __construct(DeliveryServiceInterface $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }
}
