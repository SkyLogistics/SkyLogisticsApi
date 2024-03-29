<?php declare(strict_types=1);

namespace SkyLogistics;

use SkyLogistics\Service\SkyApiService;

require __DIR__ . '/../vendor/autoload.php';
$apiService = new SkyApiService();

// GET STATUSES.
print_r($apiService->getStatuses());