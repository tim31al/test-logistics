<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Controller\Delivery;

use App\Service\Delivery\DeliveryRequestException;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeliverOfferFastController extends DeliverAbstractController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $statusCode = StatusCodeInterface::STATUS_OK;

        $body = $request->getParsedBody() ?: [];
        try {
            $data = $this->deliveryService->getFastOffers($body);
        } catch (DeliveryRequestException $exception) {
            $data = ['errors' => $exception->getErrors()];
            $statusCode = StatusCodeInterface::STATUS_BAD_REQUEST;
        }

        return $this->jsonResponse($response, $data, $statusCode);
    }
}
