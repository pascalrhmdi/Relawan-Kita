<?php
// read all history
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$start = $_GET['start'] ?? null;
$amount = $_GET['amount'] ?? null;
$userId = $_GET['id'] ?? null;

$httpResponseCode;
$response = [];

if (!empty($userId) && trim($start)!=='' && !empty($amount)) {
    $result = $crud->getRiwayatPendaftaranRelawan($userId, $start, $amount);
    $httpResponseCode = 200;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'success',
        'data' => $result
    ];
} else {
    $httpResponseCode = 400;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Please provide user id, start and amount for data request'
    ];
}

http_response_code($httpResponseCode);
echo json_encode($response);
