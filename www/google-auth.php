<?php
require_once '../vendor/autoload.php';
require_once 'settings.php';

$params = [
    'client_id'     => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'grant_type'    => 'authorization_code',
    'code'          => $_GET['code'],
];

$client = new \GuzzleHttp\Client();
$response = $client->post(GOOGLE_TOKEN_URI, ['form_params' => $params]);
$data = json_decode($response->getBody()->getContents(), true);

$token = $data['access_token'];
$response = $client->get(GOOGLE_USER_INFO_URI, [
    'headers' => [
        'Authorization' => 'Bearer ' . $token
    ]
]);
$data = json_decode($response->getBody()->getContents(), true);
print_r($data);