<?php

declare(strict_types=1);

namespace SkyLogistics;

use SkyLogistics\Service\SkyApiService;

require __DIR__ . '/../vendor/autoload.php';
$apiService = new SkyApiService();
$parcels = [];
$apiService->setEnvironment('test');

// see details of parameters here /docs/api/create/parcel in Sky Admin Panel

// Request. Create parcel, delivery to NovaPoshta warehouse.
$dataNovaPoshta = [
    "email" => "name@email.com",
    "fio" => "Vasiliy",
    "Ref" => 229, // Ref from Sky Admin Panel /dict/nova
    "zip" => "02140",
    "RegionId" => "10",
    "city" => "Kyiv",
    "street" => "",
    "house" => "",
    "flat" => "",
    "phone" => "380667841766",
    "typeId" => 1, // delivery to warehouse NovaPoshta or UkrPoshta or Justin
    "CourierServiceId" => "000000001", // NOVA POSHTA
    "Notes" => "Notes",
    "schet" => "12345",
    'Content' => [
        [
            "DeclaredValue" => 50.947,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1418.41,
            "CODCurrency" => "UAH",
            "Name" => "Boots",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],
        [
            "DeclaredValue" => 49,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1390.05,
            "CODCurrency" => "UAH",
            "Name" => "Shoes",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],

    ],
];
$parcels['novaWarehouse'] = $apiService->createParcel($dataNovaPoshta);


// Request. Create parcel, delivery to UkrPoshta warehouse.
$dataUkrPoshta = [
    "email" => "name@email.com",
    "fio" => "Vasiliy",
    "Ref" => 41734, // Ref from Sky Admin Panel /dict/ukr
    "zip" => "02140",
    "RegionId" => "10", // id field from /dict/regions Sky Admin Panel
    "city" => "Kyiv",
    "street" => "",
    "house" => "",
    "flat" => "",
    "phone" => "380667841766",
    "typeId" => 1, // delivery to warehouse NovaPoshta or UkrPoshta or Justin
    "CourierServiceId" => "000000004", // UKR POSHTA
    "Notes" => "Any Notes", // 255 symbols max size
    "schet" => "12345",
    'Content' => [
        [
            "DeclaredValue" => 50.947,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1418.41,
            "CODCurrency" => "UAH",
            "Name" => "Boots",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],
        [
            "DeclaredValue" => 49,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1390.05,
            "CODCurrency" => "UAH",
            "Name" => "Shoes",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],
    ],
];
$parcels['ukrWarehouse'] = $apiService->createParcel($dataUkrPoshta);


// Request. Create departure, delivery with NovaPoshta and courier.
$dataNovaPoshtaCourier = [
    "email" =>"name@email.com",
    "fio" =>"Vasiliy",
    "zip" => "02140",
    "RegionId"=> "10",
    "city" => "Kyiv",
    "street" => "Revutskogo",
    "house"=> "44",
    "flat"=> "276",
    "phone"=> "380667841766",
    "typeId"=> 0, // delivery to address with warehouse NovaPoshta or UkrPoshta or Justin
    "CourierServiceId"=> "000000001",
    "Notes"=> "Notes",
    "schet"=> "12345",
    'Content' => [
        [
            "DeclaredValue" => 50.947,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1418.41,
            "CODCurrency" => "UAH",
            "Name" => "Boots",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],
        [
            "DeclaredValue" => 49,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1390.05,
            "CODCurrency" => "UAH",
            "Name" => "Shoes",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],
    ],
];
$parcels['novaPoshtaCourier'] = $apiService->createParcel($dataNovaPoshtaCourier);

// Request. Create departure, delivery with UkrPoshta and courier.
$dataUkrPoshtaCourier = [
    "email" =>"name@email.com",
    "fio" =>"Vasiliy",
    "zip" => "02140",
    "RegionId"=> "10",
    "city" => "Kyiv",
    "street" => "Revutskogo",
    "house"=> "44",
    "flat"=> "276",
    "phone"=> "380667841766",
    "typeId"=> 0, // delivery to address with warehouse NovaPoshta or UkrPoshta or Justin
    "CourierServiceId"=> "000000004",
    "Notes"=> "Notes",
    "schet"=> "12345",
    'Content' => [
        [
            "DeclaredValue" => 50.947,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1418.41,
            "CODCurrency" => "UAH",
            "Name" => "Boots",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],
        [
            "DeclaredValue" => 49,
            "DeclaredCurrency" => "EUR",
            "CODAmount" => 1390.05,
            "CODCurrency" => "UAH",
            "Name" => "Shoes",
            "Weight" => 0.9,
            "Count" => 1,
            "Notes" => "Any text", // 255 symbols max size
            "codcn" => "123456"
        ],
    ],
];
$parcels['ukrPoshtaCourier'] = $apiService->createParcel($dataUkrPoshtaCourier);

print_r($parcels);