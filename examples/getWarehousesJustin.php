<?php declare(strict_types=1);

namespace SkyLogistics;

use GuzzleHttp\Client;
use SkyLogistics\Service\SkyApiService;

require __DIR__ . '/../vendor/autoload.php';
$credentials = [];
$apiService = new SkyApiService(new Client());

require __DIR__.'/../env.php';
if ($credentials === []) {
    exit('Check your env.php file and put credentials');
}
$apiService->auth($credentials['API_LOGIN'], $credentials['API_KEY']);
//$apiService->setEnvironment('test');

// GET WAREHOUSES.
// NOVA POSHTA FIRST PAGE
$warehouses = $apiService->getWarehouses('000000006', 10, 1);
if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
    print_r($warehouses['response']['result']);
} else {
    print_r($warehouses['errors']);
}