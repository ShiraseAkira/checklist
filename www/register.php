<?php require_once 'boot.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <?php flash(); ?>
    <form method="post" action="do_register.php">
    <div>
        <label for="username">Имя пользователя</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Регистрация</button>
    </form>
</body>
</html>