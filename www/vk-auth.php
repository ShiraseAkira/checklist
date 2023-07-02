<?php
require_once 'boot.php';

$params = [
    'client_id'     => $_ENV['VK_APP_ID'],
    'client_secret' => $_ENV['VK_APP_SECRET'],
    'redirect_uri'  => VK_REDIRECT_URI,
    'code'          => $_GET['code'],
];

$token_uri = VK_TOKEN_URI . '?' . http_build_query($params);
$token = json_decode(file_get_contents($token_uri), true);

$params = [
    'uids'         => $token['user_id'],
    'fields'       => VK_REQUIRED_USER_INFO,
    'access_token' => $token['access_token'],
    'v'            => VK_API_VERSION
];
$user_info_uri = VK_USERS_GET_URI . '?' . http_build_query($params);
$userInfo = json_decode(file_get_contents($user_info_uri), true);
$userInfo = $userInfo['response'][0];

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `vk_id` = :vk_id");
$stmt->execute(['vk_id' => $userInfo['id']]);
if (!$stmt->rowCount()) {
    $stmt = pdo()->prepare("INSERT INTO `users` (`vk_id`, `display_name`) VALUES (:vk_id, :display_name)");
    $stmt->execute([
        'vk_id' => $userInfo['id'],
        'display_name' => $userInfo['first_name'] . ' ' . $userInfo['last_name'],
    ]);

    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `vk_id` = :vk_id");
    $stmt->execute(['vk_id' => $userInfo['id']]);
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['id_user'] = $user['id_user'];
$_SESSION['display_name'] = $user['display_name'];
header('Location: /');
