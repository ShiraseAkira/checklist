<?php
require_once 'boot.php';

if(!isset($_SESSION['id_user'])) {
    header('Location: /');
} else {
    $stmt = pdo()->prepare("SELECT * FROM `checklist_items` WHERE `id_checklist` = :id_checklist");
    $stmt->execute(['id_checklist' => $_GET['id_checklist']]);
    $items = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($items);
}