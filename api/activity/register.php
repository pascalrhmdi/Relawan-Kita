<?php
// register to become volunteer
include('../headers.php');
header("Access-Control-Allow-Methods: POST");

include("../../db/connect.php");

$httpResponseCode;
$response = [];

// parse_str(file_get_contents('php://input'), $_PUT);
// $userId = $_PUT['userId'] ?? null;
// $eventId = $_PUT['eventId'] ?? null;

$userId = $_POST['userId'] ?? null;
$eventId = $_POST['eventId'] ?? null;

if ($userId !== null && $eventId !== null && trim($userId)!== '' && trim($eventId)!=='') {
    $event = $crud->getAcaraRegistrationDeadlineById($eventId);

    // jika data tidak ditemukan
    if (!$event) {
        $httpResponseCode = 404;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Not Found',
        ];
    } else {
        $eventRegistrationDeadline = $event['tanggal_batas_registrasi'];

        // jika mendaftar sebelum deadline registrasi
        if (date("Y-m-d") <= $eventRegistrationDeadline) {
            try {
                $crud->insertStatus($userId, $eventId);

                $httpResponseCode = 201;

                $response = [
                    'status' => $httpResponseCode,
                    'message' => 'Success'
                ];
            } catch (\Throwable $th) {
                $httpResponseCode = 409;

                $response = [
                    'status' => $httpResponseCode,
                    'message' => 'Failed to create data! User already registered in this event'
                ];
            }
        } else {
            $httpResponseCode = 409;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Failed to create data! Exceeded event registration deadline'
            ];
        }
    }
} else {
    $httpResponseCode = 400;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Please provide userId and eventId'
    ];
}


http_response_code($httpResponseCode);
echo json_encode($response);
