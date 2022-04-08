<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Service\Company;

class CompanyService implements CompanyServiceInterface
{
    public const BASE_PRICE = 150;

    public function getFastOffers(array $data): array
    {
        $result = [];

        foreach (range(1, 5) as $i) {
            $result[] = [
                'company_id' => $i,
                'price' => $this->getRandomFloat(100, 10000),
                'period' => random_int(1, 5),
            ];
        }

        return $result;
    }

    public function getSlowOffers(array $data): array
    {
        $result = [];

        foreach (range(1, 5) as $i) {
            $day = random_int(1, 31);
            $date = '2022-04-'.($day < 10 ? '0'.$day : $day);

            $result[] = [
                'company_id' => $i,
                'coefficient' => $this->getRandomFloat(1, 10),
                'date' => $date,
            ];
        }

        return $result;
    }

    private function getRandomFloat(int $min, int $max)
    {
        return random_int($min, $max) + random_int(1, 99) / 100;
    }

    public function getOffer(array $data): array
    {
        if ($data['date']) {
            return $this->getSlowOffer($data);
        }

        return $this->getFastOffer($data);
    }

    private function getSlowOffer(array $data): array
    {
        $price = $data['coefficient'] * self::BASE_PRICE;

        return [
            'company_id' => $data['company_id'],
            'price' => round($price, 2, \PHP_ROUND_HALF_UP),
            'date' => $data['date'],
        ];
    }

    private function getFastOffer(array $data): array
    {
        $curDate = new \DateTime('now');
        $hour = (int) $curDate->format('H');
        if ($hour >= 18) {
            $interval = $data['period'] + 1;
        } else {
            $interval = $data['period'];
        }

        $curDate->add(\DateInterval::createFromDateString($interval.' days'));

        return [
            'company_id' => $data['company_id'],
            'price' => $data['price'],
            'date' => $curDate->format('Y-m-d'),
        ];
    }
}
