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
    <link rel="stylesheet" href="styles/style.css">
    <title>Checklist</title>
</head>
<body>

<?php if(isset($_SESSION['id_user'])) { ?>
    <div class="wrapper">
        <header>
            <a href="/">Главная</a>
            <div>
                <div>
                    <h3>
                        <?php echo $_SESSION['display_name'] ?> 
                    </h3>
                </div>
                <form method="post" action="do_logout.php">
                    <button type="submit">Выход</button>
                </form>
            </div>
        </header> 
    </div>
    <div class="wrapper">
        <main>
<?php 
    $stmt = pdo()->query("SELECT * FROM `checklists`", PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
    foreach($rows as $row) { ?>
        <div class="checklist">
            <h2>
                <a href="<?= "/checklist.php?id_checklist=" . $row['id_checklist'] ?>">
                    <?= $row['name'] ?>
                </a>
            </h2>
            <?php if(isset($row['description'])) { ?>
                <div class="checklist-description">
                    <?= $row['description'] ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

        </main>
    </div>

<?php } else { ?>
    <?php flash(); ?>
    <div class="login-wrapper">
        <div class="login-form">
            <h2>Войдите для начала работы</h2>
            <form method="post" action="do_login.php">
                <div class="form-elem">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-elem">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-elem">
                    <a href="register.php">Регистрация</a>
                    <button type="submit">Войти</button>
                </div>
                
            </form>
            <p>или войдите через соц.сети:</p>
            <a href="<?= $google_auth_uri ?>">Google</a>
            <a href="<?= $vk_auth_uri ?>">ВКонтакте</a>
        </div>
    </div>
<?php } ?>

</body>
</html>