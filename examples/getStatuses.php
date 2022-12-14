<?php declare(strict_types=1);

namespace SkyLogistics;

use GuzzleHttp\Client;
use SkyLogistics\Service\SkyApiService;

require __DIR__ . '/../vendor/autoload.php';
$apiService = new SkyApiService(new Client());
//$apiService->setEnvironment('test');

// GET STATUSES.
print_r($apiService->getStatuses());