<?php

const GOOGLE_SCOPES = [
    'https://www.googleapis.com/auth/userinfo.email',
    'https://www.googleapis.com/auth/userinfo.profile'
];
const GOOGLE_AUTH_URI = 'https://accounts.google.com/o/oauth2/auth';
const GOOGLE_TOKEN_URI = 'https://accounts.google.com/o/oauth2/token';
const GOOGLE_USER_INFO_URI = 'https://www.googleapis.com/oauth2/v1/userinfo';
const GOOGLE_REDIRECT_URI = 'http://localhost/google-auth.php';

const VK_AUTH_URI = 'http://oauth.vk.com/authorize';
const VK_TOKEN_URI = 'https://oauth.vk.com/access_token';
const VK_REDIRECT_URI = 'http://localhost/vk-auth.php';
const VK_USERS_GET_URI = 'https://api.vk.com/method/users.get';
const VK_REQUIRED_USER_INFO = 'uid,first_name,last_name,screen_name';
const VK_API_VERSION = '5.131';

?>