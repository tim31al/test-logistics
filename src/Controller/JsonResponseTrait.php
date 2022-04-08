<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

trait JsonResponseTrait
{
    protected function jsonResponse(ResponseInterface $response, array $data, $statusCode = 200): ResponseInterface
    {
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
}
