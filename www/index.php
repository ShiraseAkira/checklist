<?php
require_once 'boot.php';

$google_auth_params = [
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'client_id'     =>  $_ENV['GOOGLE_CLIENT_ID'],
    'scope'         => implode(' ', GOOGLE_SCOPES),
];

$google_auth_uri = GOOGLE_AUTH_URI . '?' . http_build_query($google_auth_params);

$vk_auth_params = [
    'client_id'     => $_ENV['VK_APP_ID'],
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

<?php if(isset($_SESSION['id_user'])) { ?>

    <h1>Привет, <?php echo $_SESSION['display_name'] ?>
    <form method="post" action="do_logout.php">
        <button type="submit">Выход</button>
    </form>

<?php 
    $stmt = pdo()->query("SELECT * FROM `checklists`", PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
    foreach($rows as $row) { ?>
        <h2>
            <a href="<?= "/checklist.php?id_checklist=" . $row['id_checklist'] ?>">
                <?= $row['name'] ?>
            </a>
        </h2>
        <div>
            <?= $row['description'] ?>
        </div>
    <?php }
?>

<?php } else { ?>
    <?php flash(); ?>
    <form method="post" action="do_login.php">
        <div>
            <label for="username">Имя пользователя</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Войти</button>
    </form>
    <p>или</p>
    <a href="register.php">Регистрация</a>
    <a href="<?= $google_auth_uri ?>">Войти через Google</a>
    <a href="<?= $vk_auth_uri ?>">Войти через ВКонтакте</a>

<?php } ?>

</body>
</html>