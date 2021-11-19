<?php
// register to become volunteer
include('../headers.php');
header("Access-Control-Allow-Methods: POST");

include("../../db/connect.php");

$httpResponseCode;
$response = [];

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'] ?? null;
$eventId = $data['eventId'] ?? null;

// $userId = $_POST['userId'] ?? null;
// $eventId = $_POST['eventId'] ?? null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
    if ($userId !== null && $eventId !== null && trim($userId) !== '' && trim($eventId) !== '') {
        $event = $crud->getAcaraRegistrationDeadlineById($eventId);

        // jika data tidak ditemukan
        if (!$event) {
            $httpResponseCode = 404;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Acara tidak ditemukan!',
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
                        'message' => 'Selamat! Anda sukses mendaftar menjadi relawan pada acara ini'
                    ];
                } catch (\Throwable $th) {
                    $httpResponseCode = 409;

                    $response = [
                        'status' => $httpResponseCode,
                        'message' => 'Gagal mendaftar menjadi relawan! Anda sudah terdaftar sebagai relawan pada acara ini'
                    ];
                }
            } else {
                $httpResponseCode = 409;

                $response = [
                    'status' => $httpResponseCode,
                    'message' => 'Gagal mendaftar menjadi relawan! Batas waktu pendaftaran relawan telah terlewat'
                ];
            }
        }
    } else {
        $httpResponseCode = 400;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Silahkan sediakan data berupa id user (userId) dan id event (eventId)'
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