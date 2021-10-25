<?php
// read all activity
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$httpResponseCode;
$response = [];


$result = $crud->getJenisAcaraLimit(0, 1000)->fetchAll();
$httpResponseCode = 200;

$response = [
    'status' => $httpResponseCode,
    'message' => 'success',
    'data' => $result
];

http_response_code($httpResponseCode);
echo json_encode($response);
