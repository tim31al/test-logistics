<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

use App\Controller\Delivery\DeliverOfferFastController;
use App\Controller\Delivery\DeliverOfferSlowController;
use App\Controller\Delivery\DeliveryController;
use App\Middleware\CorsMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->add(CorsMiddleware::class);

    $app->group('/', function (RouteCollectorProxy $v1Group) {
        $v1Group->group('delivery', function (RouteCollectorProxy $deliverGroup) {
            $deliverGroup->get('', DeliveryController::class);
            $deliverGroup->post('/fast', DeliverOfferFastController::class);
            $deliverGroup->post('/slow', DeliverOfferSlowController::class);
            $deliverGroup->post('/offer', DeliveryController::class);
        });
    });
};
