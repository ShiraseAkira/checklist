<?php
require_once 'boot.php';

$post_data = json_decode(file_get_contents('php://input'), true); 

if ($post_data['type'] == 'item') {
    $table = "item_states";
    $id_type = "id_item";
} else {
    $table = "subitem_states";
    $id_type = "id_subitem";
}

$stmt = pdo()->prepare("INSERT INTO $table (`id_user`, $id_type, `is_checked`) VALUES (:id_user, :id_item, :value)
                        ON DUPLICATE KEY UPDATE `is_checked` = :value");
$stmt->execute([
    'id_user' => $_SESSION['id_user'],
    'id_item' => $post_data['id_item'],
    'value' => $post_data['value']
]);
