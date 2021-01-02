<?php declare(strict_types=1);

namespace Review;

use GuzzleHttp\Client;
use SkyLogistics\Service\SkyApiService;

require __DIR__ . '/vendor/autoload.php';
$credentials = [];
$apiService = new SkyApiService(new Client());

require 'env.php';
if ($credentials === []) {
    exit('Check your env.php file and put credentials');
}
$apiService->auth($credentials['API_LOGIN'], $credentials['API_KEY']);
//$apiService->setEnvironment('test');

// GET PARCEL INFO.
$parcelInfo = $apiService->getParcelInfo('CR115032370PL');
print_r($parcelInfo);

// GET STATUSES.
$statuses = $apiService->getStatuses();
print_r($statuses);


// GET WAREHOUSES.
// NOVA POSHTA FIRST PAGE
$warehouses = $apiService->getWarehouses('000000001', 10, 1);
if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
    print_r($warehouses['response']['result']);
} else {
    print_r($warehouses['errors']);
}

// UKR POSHTA FIRST PAGE
$warehouses = $apiService->getWarehouses('000000004', 10, 1);
if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
    print_r($warehouses['response']['result']);
} else {
    print_r($warehouses['errors']);
}

// JUSTIN FIRST PAGE
$warehouses = $apiService->getWarehouses('000000006', 10, 1);
if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
    print_r($warehouses['response']['result']);
} else {
    print_r($warehouses['errors']);
}
