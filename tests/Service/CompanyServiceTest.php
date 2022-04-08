<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

use App\Service\Company\CompanyService;
use PHPUnit\Framework\TestCase;

class CompanyServiceTest extends TestCase
{
    protected CompanyService $service;

    protected function setUp(): void
    {
        $this->service = new CompanyService();
    }

    public function testGetFastOffers()
    {
        $offers = $this->service->getFastOffers([]);

        $this->assertCount(5, $offers);

        for ($i = 0; $i < 5; ++$i) {
            $this->assertSame($i + 1, $offers[$i]['company_id']);
            $this->assertArrayHasKey('price', $offers[$i]);
            $this->assertArrayHasKey('period', $offers[$i]);
        }
    }

    public function testGetSlowOffers()
    {
        $offers = $this->service->getSlowOffers([]);

        $this->assertCount(5, $offers);

        for ($i = 0; $i < 5; ++$i) {
            $this->assertSame($i + 1, $offers[$i]['company_id']);
            $this->assertArrayHasKey('coefficient', $offers[$i]);
            $this->assertArrayHasKey('date', $offers[$i]);
        }
    }

    public function testGetFastOffer()
    {
        $data = [
            'company_id' => 1,
            'period' => 3,
            'price' => 2.22,
        ];

        $interval = (new \DateTime('now'))->format('H') >= 18 ? 4 : 3;

        $date = (new \DateTime('now'))->add(\DateInterval::createFromDateString($interval.' days'));

        $result = $this->service->getOffer($data);
        $this->assertIsArray($result);

        $this->assertSame($result['company_id'], 1);
        $this->assertSame($result['date'], $date->format('Y-m-d'));
        $this->assertSame($result['price'], 2.22);
    }

    public function testGetSlowOffer()
    {
        $data = [
            'company_id' => 1,
            'coefficient' => 1.75,
            'date' => '2022-04-08',
        ];

        $result = $this->service->getOffer($data);
        $this->assertIsArray($result);

        $this->assertSame($result['company_id'], 1);
        $this->assertSame($result['date'], '2022-04-08');
        $this->assertSame($result['price'], 262.5);
    }
}
