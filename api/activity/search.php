<?php
// search activity
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$start = $_GET['start'] ?? null;
$amount = $_GET['amount'] ?? null;
$key = $_GET['key'] ?? null;
$requestMethod = $_SERVER["REQUEST_METHOD"];

$httpResponseCode;
$response = [];

if ($requestMethod == 'GET') {
    if (trim($start) !== null && !empty($amount) && !empty($key)) {
        $queryKeyword = explode(":", $key);

        // untuk query search berdasarkan kategori
        if (count($queryKeyword) > 0 && $queryKeyword[0] == 'kategori') {
            $result = $crud->searchAcaraByCategory($start, $amount, $queryKeyword[1])->fetchAll();
        } else {
            // untuk query search general
            $result = $crud->searchAcaraByKey($start, $amount, $key)->fetchAll();
        }

        $httpResponseCode = 200;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Sukses',
            'data' => $result
        ];
    } else {
        $httpResponseCode = 400;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Silahkan sediakan keyword pencarian, serta parameter awal data (start), dan jumlah data (amount) yang ingin didapatkan'
        ];
    }
} else {
    $httpResponseCode = 405;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Metode tidak diperbolehkan!'
    ];
}

http_response_code($httpResponseCode);
echo json_encode($response);
