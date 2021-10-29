<?php
// read all activity
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$start = $_GET['start'] ?? null;
$amount = $_GET['amount'] ?? null;
$key = $_GET['key'] ?? null;

$httpResponseCode;
$response = [];

if (trim($start) !== null && !empty($amount) && !empty($key)) {
    $result = $crud->searchAcaraByKey($start,$amount,$key)->fetchAll();

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
        'message' => 'Please provide key, start and amount for data request'
    ];
}

http_response_code($httpResponseCode);
echo json_encode($response);
