<?php
// register a new volunteer
include('../headers.php');
header("Access-Control-Allow-Methods: PUT");

include("../../db/connect.php");

$httpResponseCode;
$response = [];

parse_str(file_get_contents('php://input'), $rawData);
$data = (object) $rawData;

$userId = $_GET['id'] ?? null;

if (!empty($userId)) {
    if (
        !empty($data->nama) && !empty($data->alamat) && !empty($data->nomor_telepon)
        && !empty($data->jenis_kelamin) && !empty($data->tanggal_lahir)
    ) {
        $result = $user->updateUserRelawan($userId, $data->nama, $data->jenis_kelamin, $data->alamat, $data->nomor_telepon, $data->tanggal_lahir);

        if (!$result) {
            $httpResponseCode = 409;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Failed to update user data!'
            ];
        } else {
            $httpResponseCode = 200;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'success',
                'data' => [
                    'id_pengguna' => $userId,
                    'nama' => $data->nama,
                    'alamat' => $data->alamat,
                    'nomor_telepon' => $data->nomor_telepon,
                    'jenis_kelamin' => $data->jenis_kelamin,
                    'tanggal_lahir' => $data->tanggal_lahir,
                ]
            ];
        }
    } else {
        $httpResponseCode = 503;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Failed to update!'
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
