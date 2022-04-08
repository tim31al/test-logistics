<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace Tests\Utils;

use App\Service\Delivery\DeliveryRequestValidator;
use App\Utils\Config;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ConfigTest extends TestCase
{
    public function testBuildContainer()
    {
        $config = new Config();
        $container = $config->buildContainer();

        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    public function testSettings()
    {
        $config = new Config();
        $container = $config->buildContainer();

        $appName = $container->get('app_name');
        $development = $container->get('development');
        $this->assertSame('Logistics', $appName);
        $this->assertTrue($development);
    }

    public function testServices()
    {
        $config = new Config();
        $container = $config->buildContainer();

        $validator = $container->get(DeliveryRequestValidator::class);
        $this->assertInstanceOf(DeliveryRequestValidator::class, $validator);
    }
}
