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
                'message' => 'Incorrect username or password! Please try again.'
            ];
        } else {
            $httpResponseCode = 200;

            $response = [
                'status' => $httpResponseCode,
                'message' => 'success',
                'data' => $userData
            ];
        }
    } else {
        $httpResponseCode = 503;

        $response = [
            'status' => $httpResponseCode,
            'message' => 'Failed to login!'
        ];
    }
} else {
    $httpResponseCode = 405;

    $response = [
        'status' => $httpResponseCode,
        'message' => 'Method Not Allowed'
    ];
}


http_response_code($httpResponseCode);
echo json_encode($response);
