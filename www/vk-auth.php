<?php
require_once '../vendor/autoload.php';
require_once 'settings.php';

if (isset($_GET['code'])) {
    $result = false;
    $params = [
        'client_id'     => VK_APP_ID,
        'client_secret' => VK_APP_SECRET,
        'redirect_uri'  => VK_REDIRECT_URI,
        'code'          => $_GET['code'],
    ];

    $token_uri = VK_TOKEN_URI . '?' . http_build_query($params);
    $token = json_decode(file_get_contents($token_uri), true);

    if (isset($token['access_token'])) {
        $params = [
            'uids'         => $token['user_id'],
            'fields'       => VK_REQUIRED_USER_INFO,
            'access_token' => $token['access_token'],
            'v'            => VK_API_VERSION
        ];
        $user_info_uri = VK_USERS_GET_URI . '?' . http_build_query($params);
        $userInfo = json_decode(file_get_contents($user_info_uri), true);

        if (isset($userInfo['response'][0]['id'])) {
            $result = true;
            $userInfo = $userInfo['response'][0];
        }
    }

    if ($result) {
        print_r($userInfo);
    }
    
}