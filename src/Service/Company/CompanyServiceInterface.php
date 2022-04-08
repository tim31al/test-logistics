<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Service\Company;

interface CompanyServiceInterface
{
    public function getSlowOffers(array $data): array;

    public function getFastOffers(array $data): array;

    public function getOffer(array $data): array;
}
