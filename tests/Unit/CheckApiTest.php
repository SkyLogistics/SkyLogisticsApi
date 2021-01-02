<?php declare(strict_types=1);

namespace SkyLogisticsTest\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
        require 'env.php';
        if ($credentials === []) {
            exit('Check your env.php file and put credentials');
        }
        $this->service->auth($credentials['API_LOGIN'], $credentials['API_KEY']);
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function testApiServiceGetStatuses(): void
    {
        $statuses = $this->service->getStatuses();
        $this->assertEquals(true, $statuses['success']);
        $this->assertEquals(true, $statuses['response']['success']);
        $this->assertEquals([], $statuses['response']['errors']);
        $this->assertEquals(1, $statuses['response']['result'][0]['id']);
        $this->assertEquals('000000001', $statuses['response']['result'][0]['code']);
        $this->assertEquals('Отправление зарегистрировано', $statuses['response']['result'][0]['name']);
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function testApiServiceWrongCredentials(): void
    {
        $this->service->auth('admin', 'test');
        $response = $this->service->getStatuses();
        $this->assertEquals(false, $response['response']['success']);
        $this->assertEquals([], $response['response']['result']);
        $this->assertEquals('Invalid credentials', $response['response']['errors'][0]);
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function testApiServiceGetWarehousesNovaPoshtaFirstPage(): void
    {
        $warehouses = $this->service->getWarehouses('000000001', 10, 1);
        $novaPoshta = [];
        if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
            foreach ($warehouses['response']['result'] as $warehouse) {
                $novaPoshta[] = $warehouse;
            }
        }

        $this->assertCount(10, $novaPoshta);
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function testApiServiceGetWarehousesUkrPoshtaFirstPage(): void
    {
        $warehouses = $this->service->getWarehouses('000000004', 10, 1);
        $ukrPoshta  = [];
        if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
            foreach ($warehouses['response']['result'] as $warehouse) {
                $ukrPoshta[] = $warehouse;
            }
        }

        $this->assertCount(10, $ukrPoshta);
    }

    /**
     * @test
     *
     * @throws GuzzleException
     */
    public function testApiServiceGetWarehousesJustinFirstPage(): void
    {
        $warehouses = $this->service->getWarehouses('000000006', 10, 1);
        $justin     = [];
        if (!$warehouses['errors'] && !$warehouses['response']['errors']) {
            foreach ($warehouses['response']['result'] as $warehouse) {
                $justin[] = $warehouse;
            }
        }

        $this->assertCount(10, $justin);
    }
}
