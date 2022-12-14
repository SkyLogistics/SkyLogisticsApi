<?php declare(strict_types=1);

namespace SkyLogistics;

use SkyLogistics\Service\SkyApiService;

require __DIR__ . '/../vendor/autoload.php';
$apiService = new SkyApiService();
$apiService->setEnvironment('dev');

// GET PARCEL INFO.
print_r($apiService->getParcelInfo('CR115533038PL'));