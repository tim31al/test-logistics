<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Service\Delivery;

interface DeliveryServiceInterface
{
    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    public function getSlowOffers(array $data): array;

    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    public function getFastOffers(array $data): array;

    /**
     * @throws \App\Service\Delivery\DeliveryRequestException
     */
    public function getOffer(array $data): array;
}
