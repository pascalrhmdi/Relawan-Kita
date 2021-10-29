<?php
// register a new volunteer
include('../headers.php');
header("Access-Control-Allow-Methods: GET");

include("../../db/connect.php");

$httpResponseCode;
$response = [];

$userId = $_GET['id'] ?? null;

if (!empty($userId)) {
    $userData = $user->getUserRelawanbyId($userId);

    if (!$userData) {
        $httpResponseCode = 404;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Not Found',
            'data' => []
        ];
    } else {
        $httpResponseCode = 200;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'success',
            'data' => [
                'id_pengguna' => $userData['id_pengguna'],
                'nama' => $userData['nama'],
                'alamat' => $userData['alamat'],
                'nomor_telepon' => $userData['nomor_telepon'],
                'jenis_kelamin' => $userData['jenis_kelamin'],
                'tanggal_lahir' => $userData['tanggal_lahir'],
            ]
        ];
    }
} else {
    $httpResponseCode = 400;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Please provide user id!'
    ];
}


http_response_code($httpResponseCode);
echo json_encode($response);
