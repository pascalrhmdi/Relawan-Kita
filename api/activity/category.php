<?php
// get all activity category
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$httpResponseCode;
$response = [];

if ($requestMethod == 'GET') {
    $result = $crud->getJenisAcaraLimit(0, 1000)->fetchAll();
    $httpResponseCode = 200;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'success',
        'data' => $result
    ];
} else {
    $httpResponseCode = 405;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Method Not Allowed'
    ];
}

http_response_code($httpResponseCode);
echo json_encode($response);
