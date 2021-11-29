<?php
// get and update volunteer user data information
include('../headers.php');
header("Access-Control-Allow-Methods: PUT");

include("../../db/connect.php");

$httpResponseCode;
$response = [];

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data['userId']) && !empty($data['password']) && !empty($data['password_baru']) && !empty($data['password_verifikasi'])) {
        $userData = $user->getUserRelawanbyId($data['userId']);

        if ($userData['password'] == md5($data['password'] . $userData['email'])) {

            if ($data['password_baru'] == $data['password_verifikasi']) {

                $result = $user->ubahPassword($data['userId'], $userData['email'], $data['password_baru']);

                if (!$result) {
                    $httpResponseCode = 409;

                    $response = [
                        'status' => $httpResponseCode,
                        'message' => 'Terjadi kesalahan! Gagal memperbarui password akun'
                    ];
                } else {
                    $httpResponseCode = 200;

                    $response = [
                        'status' => $httpResponseCode,
                        'message' => 'Password akun berhasil diperbarui!'
                    ];
                }
            } else {
                $httpResponseCode = 409;

                $response = [
                    'status' => $httpResponseCode,
                    'message' => 'Gagal memperbarui password akun! Password baru tidak sesuai dengan password verifikasi'
                ];
            }
        } else {
            $httpResponseCode = 409;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'Gagal memperbarui password akun! Password yang anda masukan salah'
            ];
        }
    } else {
        $httpResponseCode = 503;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Body tidak utuh! Gagal memperbarui password akun user'
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
