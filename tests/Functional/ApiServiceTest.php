<?php declare(strict_types=1);

namespace SkyLogisticsTest\Functional;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use SkyLogistics\Service\SkyApiService;


/**
 * Class InvestmentTest
 */
class ApiServiceTest extends TestCase
{

    private SkyApiService $apiService;

    /**
     * Constructor in every test.
     */
    protected function setUp(): void
    {
        $this->apiService = new SkyApiService(new Client());
    }

    /**
     * @test
     */
    public function testServices(): void
    {
    }
}
