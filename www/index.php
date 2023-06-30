<?php
require_once 'settings.php';

$google_auth_params = [
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'client_id'     => GOOGLE_CLIENT_ID,
    'scope'         => implode(' ', GOOGLE_SCOPES),
];

$google_auth_uri = GOOGLE_AUTH_URI . '?' . http_build_query($google_auth_params);

$vk_auth_params = [
    'client_id'     => VK_APP_ID,
    'redirect_uri'  => VK_REDIRECT_URI,
    'response_type' => 'code'

];

$vk_auth_uri = VK_AUTH_URI . '?' . http_build_query($vk_auth_params);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <a href="<?= $google_auth_uri ?>">аутентификация через Google</a>
    <a href="<?= $vk_auth_uri ?>">аутентификация через ВК</a>
</body>
</html>