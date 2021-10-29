<?php
// register a new volunteer
include('../headers.php');
header("Access-Control-Allow-Methods: POST");

include("../../db/connect.php");

$httpResponseCode;
$response = [];

parse_str(file_get_contents('php://input'), $rawData);
$data = (object) $rawData;

if (!empty($data->email) && !empty($data->password)) {
    $new_password = md5($data->password . $data->email);
    $userData = $user->getUser($data->email, $new_password);

    if (!$userData) {
        $httpResponseCode = 404;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Username or Password is incorrect! Please try again.'
        ];
    } else {
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
        'message' => 'Failed to login!'
    ];
}


http_response_code($httpResponseCode);
echo json_encode($response);
