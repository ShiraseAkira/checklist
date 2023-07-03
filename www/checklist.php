<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/style.css">
    <title>Checklist</title>
</head>
<body>

<?php
require_once 'boot.php';

if(!isset($_SESSION['id_user'])) {
    header('Location: /');
} else {
    $stmt = pdo()->prepare("SELECT i.`id_item`, i.`name`, i.`description`, si.`id_subitem`, si.`content`, 
                            i_s.`is_checked` AS is_item_checked, si_s.`is_checked` AS is_subitem_checked
                            FROM `checklist_items` AS i
                            LEFT JOIN `item_states` AS i_s
                            ON i.`id_item` = i_s.`id_item` AND i_s.`id_user` = :id_user
                            LEFT JOIN `checklist_subitems` AS si
                            ON i.`id_item` = si.`id_item`
                            LEFT JOIN `subitem_states` AS si_s
                            ON si.`id_subitem` = si_s.`id_subitem` AND si_s.`id_user` = :id_user
                            WHERE i.`id_checklist` = :id_checklist
                            ORDER BY i.`id_item`, si.`id_subitem`");
    $stmt->execute([
        'id_checklist' => $_GET['id_checklist'],
        'id_user' => $_SESSION['id_user']
    ]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $row) {

    }
    ?>

<pre>
<?php
print_r($rows);
?>
</pre>

<?php 
}
?>

</body>
</html>