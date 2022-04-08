<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App;

use App\Utils\Config;
use Psr\Container\ContainerInterface;
use Slim\App as SlimApp;
use Slim\Factory\AppFactory;

final class App
{
    private SlimApp $app;

    /**
     * App constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $config = new Config();
        $container = $config->buildContainer();

        $this->init($container);
    }

    public function run()
    {
        $this->app->run();
    }

    private function init(ContainerInterface $container): void
    {
        $app = AppFactory::createFromContainer($container);

        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
        $app->addErrorMiddleware($container->get('development'), false, false);

        // routes
        (require \dirname(__DIR__).'/config/routes/api.php')($app);

        $this->app = $app;
    }
}
