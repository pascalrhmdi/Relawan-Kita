<?php
// register a new volunteer
include('../headers.php');
header("Access-Control-Allow-Methods: POST");

include("../../db/connect.php");

$httpResponseCode;
$response = [];

parse_str(file_get_contents('php://input'), $rawData);
$data = (object) $rawData;

if (
    !empty($data->email) && !empty($data->password) && !empty($data->nama) && !empty($data->alamat)
    && !empty($data->nomor_telepon) && !empty($data->jenis_kelamin) && !empty($data->tanggal_lahir)
) {
    $result = $user->insertUser($data->email, $data->password, $data->nama, 'volunteer', $data->alamat, $data->nomor_telepon);

    if (!$result) {
        $httpResponseCode = 400;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Failed to register! Email had been registered, please use other email'
        ];
    } else {
        $crud->insertRelawan($pdo->lastInsertId(), $data->jenis_kelamin, $data->tanggal_lahir);

        $userData = $user->getUser($data->email, md5($data->password . $data->email));

        $httpResponseCode = 200;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'success',
            'data' => [
                'id_pengguna' => $userData['id_pengguna'],
                'nama' => $userData['nama'],
                'role' => $userData['role']
            ]
        ];
    }
} else {
    $httpResponseCode = 503;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Failed to register!'
    ];
}


http_response_code($httpResponseCode);
echo json_encode($response);
