<?php

declare(strict_types=1);

namespace SkyLogistics;

use GuzzleHttp\Client;
use SkyLogistics\Service\SkyApiService;

require __DIR__ . '/../vendor/autoload.php';
$apiService = new SkyApiService(new Client());
//$apiService->setEnvironment('test');

// GET WAREHOUSES.
// NOVA POSHTA FIRST PAGE
$warehouses = $apiService->getWarehouse(
    SkyApiService::NOVA_POSHTA,
    SkyApiService::DEFAULT_COUNT_RESULTS,
    SkyApiService::DEFAULT_PAGE
);

print_r($warehouses);


// UKR POSHTA FIRST PAGE
$warehouses = $apiService->getWarehouse(
    SkyApiService::UKR_POSHTA,
    SkyApiService::DEFAULT_COUNT_RESULTS,
    SkyApiService::DEFAULT_PAGE
);

print_r($warehouses);


// JUSTIN FIRST PAGE
$warehouses = $apiService->getWarehouse(
    SkyApiService::JUSTIN,
    SkyApiService::DEFAULT_COUNT_RESULTS,
    SkyApiService::DEFAULT_PAGE
);

print_r($warehouses);
