<?php
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$start = $_GET['start'] ?? null;
$amount = $_GET['amount'] ?? null;
$eventId = $_GET['id'] ?? null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

$httpResponseCode;
$response = [];

if ($requestMethod == 'GET') {
    if ($start !== null && $amount !== null) {
        // read all activity

        $result = $crud->getAcaraLimit($start, $amount)->fetchAll();
        $httpResponseCode = 200;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Sukses',
            'data' => $result
        ];
    } elseif ($eventId !== null) {
        // read single activity

        $result = $crud->getAcaraById($eventId)->fetch();
        if ($result) {
            $httpResponseCode = 200;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Sukses',
                'data' => $result
            ];
        } else {
            $httpResponseCode = 404;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Acara Tidak Ditemukan!',
                'data' => []
            ];
        }
    } else {
        $httpResponseCode = 400;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Silahkan sediakan parameter awal data (start) dan jumlah data (amount) yang ingin didapatkan'
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
