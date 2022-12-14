<?php declare(strict_types=1);

namespace SkyLogisticsTest\Unit;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use SkyLogistics\Service\SkyApiService;


class CheckApiTest extends TestCase
{
    /**
     * @var SkyApiService
     */
    private SkyApiService $service;

    /**
     * Constructor in every test.
     */
    protected function setUp(): void
    {
        $this->service = new SkyApiService(new Client);
        $credentials   = [];
        require __DIR__ . '../../env.php';
        if ($credentials === []) {
            exit('Check your env.php file and put credentials');
        }
        $this->service->auth($credentials['API_LOGIN'], $credentials['API_KEY']);
    }

    /**
     * @test
     */
    public function testApiServiceGetStatuses(): void
    {
        $statuses = $this->service->getStatuses();
        $this->assertEquals(true, $statuses['success']);
        $this->assertEquals(true, $statuses['response']['success']);
        $this->assertEquals([], $statuses['response']['errors']);
        $this->assertEquals(1, $statuses['response']['result'][0]['id']);
        $this->assertEquals(SkyApiService::DEFAULT_COUNT_RESULTS, $statuses['response']['result'][0]['code']);
        $this->assertEquals(SkyApiService::PARCEL_REGISTERED, $statuses['response']['result'][0]['name']);
    }

    /**
     * @test
     */
    public function testApiServiceWrongCredentials(): void
    {
        $this->service->auth(SkyApiService::SOME_LOGIN, SkyApiService::SOME_KEY);
        $response = $this->service->getStatuses();
        $this->assertEquals(false, $response['response']['success']);
        $this->assertEquals([], $response['response']['result']);
        $this->assertEquals('Invalid credentials', $response['response']['errors'][0]);
    }

    /**
     * @test
     */
    public function testApiServiceGetWarehousesNovaPoshtaFirstPage(): void
    {
        $warehouses = $this->service->getWarehouses(SkyApiService::NOVA_POSHTA, 10, 1);
        $novaPoshta = [];
        if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
            foreach ($warehouses['response']['result'] as $warehouse) {
                $novaPoshta[] = $warehouse;
            }
        }

        $this->assertCount(SkyApiService::DEFAULT_COUNT_RESULTS, $novaPoshta);
    }

    /**
     * @test
     */
    public function testApiServiceGetWarehousesUkrPoshtaFirstPage(): void
    {
        $warehouses = $this->service->getWarehouses(SkyApiService::UKR_POSHTA, 10, 1);
        $ukrPoshta  = [];
        if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
            foreach ($warehouses['response']['result'] as $warehouse) {
                $ukrPoshta[] = $warehouse;
            }
        }

        $this->assertCount(SkyApiService::DEFAULT_COUNT_RESULTS, $ukrPoshta);
    }

    /**
     * @test
     */
    public function testApiServiceGetWarehousesJustinFirstPage(): void
    {
        $warehouses = $this->service->getWarehouses(
            SkyApiService::JUSTIN,
            SkyApiService::DEFAULT_COUNT_RESULTS,
            SkyApiService::DEFAULT_PAGE
        );
        $justin     = [];
        if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
            foreach ($warehouses['response']['result'] as $warehouse) {
                $justin[] = $warehouse;
            }
        }

        $this->assertCount(SkyApiService::DEFAULT_COUNT_RESULTS, $justin);
    }
}
