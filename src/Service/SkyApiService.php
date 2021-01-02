<?php declare(strict_types=1);

namespace SkyLogistics\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class SkyApiService
{
    const API_SKY_SERVICE_URL      = 'https://api2.skylogisticspl.com/';
    const API_SKY_SERVICE_TEST_URL = 'https://test.skylogisticspl.com/';

    const ENV_TEST = 'test';
    const ENV_DEV  = 'dev';

    const WRONG_CREDENTIALS = 'login or/and key is empty';

    const NOVA_POSHTA = '000000001';
    const UKR_POSHTA  = '000000004';
    const JUSTIN      = '000000006';

    const COURIER_SERVICES = [
        self::NOVA_POSHTA,
        self::UKR_POSHTA,
        self::JUSTIN,
    ];

    /**
     * @var Client
     */
    private Client $guzzle;

    /**
     * @var string
     */
    private string $login = '';

    /**
     * @var string
     */
    private string $key = '';

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
    }

    /**
     * Get current API url.
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        if ($this->environment === self::ENV_TEST) {
            return self::API_SKY_SERVICE_TEST_URL;
        }

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
     * Set user Authenticate;
     *
     * @param string $login
     * @param string $key
     */
    public function auth(string $login, string $key): void
    {
        $this->login = $login;
        $this->key   = $key;
    }

    /**
     * Check if login and key is set.
     *
     * @return bool
     */
    private function isAuth(): bool
    {
        if ($this->login !== '' && $this->key !== '') {
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
        $errors  = [];
        $success = false;
        $result  = [];

        if ($this->isAuth()) {
            $success = true;
            try {
                $response = $this->guzzle->post($this->getApiUrl() . 'v2/get/statuses', [
                    RequestOptions::JSON => [
                        'login' => $this->login,
                        'key'   => $this->key,
                    ]
                ]);
                $result = json_decode($response->getBody()->getContents(), true);
            } catch (GuzzleException $exception) {
                $errors[] = $exception->getMessage();
            }
        } else {
            $errors[] = self::WRONG_CREDENTIALS;
        }

        return [
            'success'  => $success,
            'errors'   => $errors,
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
    public function getWarehouses(string $courierServiceId, int $countResultsOnPage = 1000, int $page = 1): array
    {
        $errors  = [];
        $success = false;
        $result  = [];

        if ($page <= 0) {
            $page = 1;
        }

        if (!in_array($courierServiceId, self::COURIER_SERVICES)) {
            $errors[] = sprintf('CourierServiceId can be only one of this values %s', json_encode(self::COURIER_SERVICES));
        }

        if (!$errors) {
            if ($this->isAuth()) {
                $success = true;
                try {
                    $response = $this->guzzle->post($this->getApiUrl() . 'v2/get/warehouses', [
                        RequestOptions::JSON => [
                            'login'              => $this->login,
                            'key'                => $this->key,
                            'CourierServiceId'   => $courierServiceId,
                            'Page'               => $page,
                            'CountResultsOnPage' => $countResultsOnPage
                        ]
                    ]);
                    $result = json_decode($response->getBody()->getContents(), true);
                } catch (GuzzleException $exception) {
                    $errors[] = $exception->getMessage();
                }
            } else {
                $errors[] = self::WRONG_CREDENTIALS;
            }
        }

        return [
            'success'  => $success,
            'errors'   => $errors,
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
        $errors  = [];
        $success = false;
        $result  = [];

        if ($this->isAuth()) {
            $success = true;
            try {
                $response = $this->guzzle->post($this->getApiUrl() . 'v2/get/parcelInfo', [
                    RequestOptions::JSON => [
                        'login'        => $this->login,
                        'key'          => $this->key,
                        'parcelNumber' => $parcelNumber,
                    ]
                ]);
                $result = json_decode($response->getBody()->getContents(), true);
            } catch (GuzzleException $exception) {
                $errors[] = $exception->getMessage();
            }
        } else {
            $errors[] = self::WRONG_CREDENTIALS;
        }

        return [
            'success'  => $success,
            'errors'   => $errors,
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
        $errors   = [];
        $success  = false;
        $dataJson = json_encode($parcelData);

        if ($this->isAuth()) {
            echo $dataJson;
            $success = true;
        } else {
            $errors[] = 'login or/and key is empty';
        }

        return [
            'success' => $success,
            'errors'  => $errors
        ];
    }
}
