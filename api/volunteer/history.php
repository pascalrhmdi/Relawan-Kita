<?php
// get all volunteer's registration history
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$start = $_GET['start'] ?? null;
$amount = $_GET['amount'] ?? null;
$userId = $_GET['id'] ?? null;
$requestMethod = $_SERVER["REQUEST_METHOD"];

$httpResponseCode;
$response = [];

if ($requestMethod == 'GET') {
    if (!empty($userId) && trim($start) !== '' && !empty($amount)) {
        $result = $crud->getRiwayatPendaftaranRelawan($userId, $start, $amount);
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
            'message' => 'Silahkan sediakan id user, dan parameter awal data (start) dan jumlah data (amount) yang ingin didapatkan'
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
