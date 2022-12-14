<?php

declare(strict_types=1);

namespace SkyLogistics\Service;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class SkyApiService
{
    const API_SKY_SERVICE_URL = 'https://api2.skylogisticspl.com/';
    //const API_SKY_SERVICE_TEST_URL = 'https://test.skylogisticspl.com/';

    const ENV_TEST = 'test';
    const ENV_DEV = 'dev';

    const WRONG_CREDENTIALS = 'login or/and key is empty';

    const NOVA_POSHTA = '000000001';
    const UKR_POSHTA = '000000004';
    const JUSTIN = '000000006';
    const PARCEL_REGISTERED = 'Отправление зарегистрировано';

    const DEFAULT_COUNT_RESULTS = 10;
    const DEFAULT_PAGE = 1;

    const COURIER_SERVICES = [
        self::NOVA_POSHTA,
        self::UKR_POSHTA,
        self::JUSTIN,
    ];

    /**
     * @var Client
     */
    private Client $guzzle;

    private $credentials = [];

    /**
     * @var string
     */
    public string $environment = self::ENV_DEV;

    /**
     * ApiService constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->guzzle = $client;
        $this->credentials = Dotenv::createImmutable(__DIR__ . '../../');
    }

    /**
     * Get current API url.
     *
     * @return string
     */
    public function getApiUrl(): string
    {
//        THIS IS NOT WORKING FOR NOW
//        if ($this->environment === self::ENV_TEST) {
//            return self::API_SKY_SERVICE_TEST_URL;
//        }

        return self::API_SKY_SERVICE_URL;
    }

    /**
     * Set environment.
     *
     * @param string $env
     */
    public function setEnvironment(string $env = self::ENV_TEST): void
    {
        $this->environment = self::ENV_TEST;
        if ($env !== self::ENV_TEST) {
            $this->environment = self::ENV_DEV;
        }
    }

    /**
     * Check if login and key is set.
     *
     * @return bool
     */
    private function isAuth(): bool
    {
        if ($this->credentials['API_LOGIN'] !== '' && $this->credentials['API_KEY'] !== '') {
            return true;
        }

        return false;
    }

    /**
     * Get all statuses from SkyLogistics API.
     *
     * @return array
     */
    public function getStatuses(): array
    {
        $errors = [];
        $success = false;
        $result = [];

            try {
                $response = $this->guzzle->post($this->getApiUrl() . 'v2/get/statuses', [
                    RequestOptions::JSON => [
                        'login' => $this->credentials['API_LOGIN'],
                        'key' => $this->credentials['API_KEY'],
                    ]
                ]);
                $result = json_decode($response->getBody()->getContents(), true);
                if (!$result['errors']) {
                    $success = true;
                }
            } catch (GuzzleException $exception) {
                $errors[] = $exception->getMessage();
            }

        return [
            'success' => $success,
            'errors' => $errors,
            'response' => $result,
        ];
    }

    /**
     * Get warehouses from API.
     *
     * @param string $courierServiceId
     * @param int $countResultsOnPage
     * @param int $page
     *
     * @return array
     */
    public function getWarehouse(
        string $courierServiceId,
        int $countResultsOnPage = self::DEFAULT_COUNT_RESULTS,
        int $page = 1
    ): array {
        $errors = [];
        $success = false;
        $result = [];

        if ($page <= 0) {
            $page = self::DEFAULT_PAGE;
        }

        if ($countResultsOnPage <= 0) {
            $page = self::DEFAULT_COUNT_RESULTS;
        }

        if (!in_array($courierServiceId, self::COURIER_SERVICES)) {
            $errors[] = sprintf(
                'CourierServiceId can be only one of this values %s',
                json_encode(self::COURIER_SERVICES)
            );
        }

        if (!$errors) {
            $success = true;
            try {
                $response = $this->guzzle->post($this->getApiUrl() . 'v2/get/warehouses', [
                    RequestOptions::JSON => [
                        'login' => $this->credentials['API_LOGIN'],
                        'key' => $this->credentials['API_KEY'],
                        'CourierServiceId' => $courierServiceId,
                        'Page' => $page,
                        'CountResultsOnPage' => $countResultsOnPage
                    ]
                ]);
                $result = json_decode($response->getBody()->getContents(), true);
            } catch (GuzzleException $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        return [
            'success' => $success,
            'errors' => $errors,
            'response' => $result,
        ];
    }

    /**
     * Get parcel info.
     *
     * @param string $parcelNumber
     *
     * @return array
     */
    public function getParcelInfo(string $parcelNumber): array
    {
        $success = false;
        $result = [];
        $errors = [];

        try {
            $response = $this->guzzle->post($this->getApiUrl() . 'v2/get/parcelInfo', [
                RequestOptions::JSON => [
                    'login' => $this->credentials['API_LOGIN'],
                    'key' => $this->credentials['API_KEY'],
                    'parcelNumber' => $parcelNumber,
                ]
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $exception) {
            $errors[] = $exception->getMessage();
        }

        return [
            'success' => $success,
            'errors' => $errors,
            'response' => $result,
        ];
    }

    /**
     * Create parcel.
     *
     * @param array $parcelData
     *
     * @return array
     */
    public function createParcel(array $parcelData): array
    {
        $errors = [];
        $success = false;
        $dataJson = json_encode($parcelData);


        //CREATE PARCEL

        return [
            'success' => $success,
            'errors' => $errors
        ];
    }
}
