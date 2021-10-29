<?php
// read single activity
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$eventId = $_GET['id'] ?? null;

$httpResponseCode;
$response = [];

if ($eventId == null || trim($eventId) == '') {
    $httpResponseCode = 400;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Please provide an event id'
    ];
} else {
    $result = $crud->getAcaraById($eventId)->fetch();

    if ($result) {
        $httpResponseCode = 200;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'success',
            'data' => $result
        ];
    } else {
        $httpResponseCode = 404;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Not Found',
            'data' => []
        ];
    }
}

http_response_code($httpResponseCode);
echo json_encode($response);
