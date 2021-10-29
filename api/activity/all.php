<?php
// read all activity
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$start = $_GET['start'] ?? null;
$amount = $_GET['amount'] ?? null;

$httpResponseCode;
$response = [];

if ($start !== null && $amount !== null) {
    $result = $crud->getAcaraLimit($start, $amount)->fetchAll();
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
        'message' => 'Please provide start and amount for data request'
    ];
}

http_response_code($httpResponseCode);
echo json_encode($response);
