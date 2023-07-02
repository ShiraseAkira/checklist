<?php
require_once 'boot.php';

unset($_SESSION['id_user']);
unset($_SESSION['display_name']);

header('Location: /');
