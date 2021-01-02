<?php declare(strict_types=1);

namespace ReviewTest\Unit;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Review\Service\SkyApiService;

/**
 * Class InvestmentTest
 */
class ApiServiceTest extends TestCase
{
    /**
     * @var SkyApiService
     */
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
