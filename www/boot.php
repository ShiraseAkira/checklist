<?php
require_once 'settings.php';
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

session_start();

function pdo() {
    static $pdo;

    if (!isset($pdo)) {
        $dsn = 'mysql:dbname='.$_ENV['db_name'].';host='.$_ENV['db_host'];
        $pdo = new PDO($dsn, $_ENV['db_user'], $_ENV['db_pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}

function flash(?string $message = null)
{
    if ($message) {
        $_SESSION['flash'] = $message;
    } else {
        if (!empty($_SESSION['flash'])) { ?>
          <div>
              <?=$_SESSION['flash']?>
          </div>
        <?php }
        unset($_SESSION['flash']);
    }
}
?>