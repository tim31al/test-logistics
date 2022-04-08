<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

$basePath = dirname(__DIR__);
$devMode = $_ENV['DEV_MODE'];

return [
    'app_name' => 'Logistics',
    'development' => 'true' === $devMode,
];
