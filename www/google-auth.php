<?php
require_once 'boot.php';

$params = [
    'client_id'     => $_ENV['GOOGLE_CLIENT_ID'],
    'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'],
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

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `google_id` = :google_id");
$stmt->execute(['google_id' => $data['id']]);
if (!$stmt->rowCount()) {
    $stmt = pdo()->prepare("INSERT INTO `users` (`google_id`, `display_name`) VALUES (:google_id, :display_name)");
    $stmt->execute([
        'google_id' => $data['id'],
        'display_name' => $data['name'],
    ]);

    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `google_id` = :google_id");
    $stmt->execute(['google_id' => $data['id']]);
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['id_user'] = $user['id_user'];
$_SESSION['display_name'] = $user['display_name'];
header('Location: /');
