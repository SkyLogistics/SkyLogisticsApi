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

// GET STATUSES.
$statuses = $apiService->getStatuses();
print_r($statuses);