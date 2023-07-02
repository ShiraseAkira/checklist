<?php
require_once 'boot.php';

$stmt = pdo()->prepare("SELECT * FROM `users` WHERE `username` = :username");
$stmt->execute(['username' => $_POST['username']]);
if ($stmt->rowCount() > 0) {
    flash('Это имя пользователя уже занято.');
    header('Location: register.php');
    die;
}

$stmt = pdo()->prepare("INSERT INTO `users` (`username`, `password`, `display_name`) VALUES (:username, :password, :username)");
$stmt->execute([
    'username' => $_POST['username'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
]);

header('Location: index.php');
