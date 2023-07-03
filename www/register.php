<?php require_once 'boot.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/style.css">
    <title>Checklist</title>
</head>
<body>
    <?php flash(); ?>
    <div class="login-wrapper">
        <div class="login-form">
            <h2>Регистрация</h2>
            <form method="post" action="do_register.php">
                <div class="form-elem">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-elem">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-elem">
                    <button type="submit">Регистрация</button>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>