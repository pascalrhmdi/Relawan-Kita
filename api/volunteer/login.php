<?php
// login volunteer
include('../headers.php');
header("Access-Control-Allow-Methods: POST");

include("../../db/connect.php");

$httpResponseCode;
$response = [];
$requestMethod = $_SERVER["REQUEST_METHOD"];

$data = json_decode(file_get_contents('php://input'), true);

if ($requestMethod == 'POST') {
    if (!empty($data['email']) && !empty($data['password'])) {
        $new_password = md5($data['password'] . $data['email']);
        $userData = $user->getUserRelawanbyEmailAndPassword($data['email'], $new_password);

        if (!$userData) {
            $httpResponseCode = 404;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Email atau Password salah!'
            ];
        } else {
            $httpResponseCode = 200;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Sukses masuk',
                'data' => $userData
            ];
        }
    } else {
        $httpResponseCode = 503;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Gagal masuk! Body tidak utuh'
        ];
    }
} else {
    $httpResponseCode = 405;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Metode tidak diizinkan!'
    ];
}


http_response_code($httpResponseCode);
echo json_encode($response);
