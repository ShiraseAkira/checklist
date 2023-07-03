<?php
function getChecklistTitle() {
    $stmt = pdo()->prepare("SELECT `name` FROM `checklists` WHERE `id_checklist` = :id_checklist");
    $stmt->execute(['id_checklist' => $_GET['id_checklist']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 0) {
        header('Location: /');
        die;
    }

    return $rows[0]['name'];
}

function getChecklistData() {
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
    return $stmt;
}

function getChecklistImtes($rows) {
    $items = [];
    foreach ($rows as $row) {
        if (in_array($row['id_item'], array_column($items, 'id_item'))) {
            continue;
        }
        array_push($items, [
            'id_item' => $row['id_item'],
            'name' => $row['name'],
            'has_hideable' => isset($row['description']) or isset($row['id_subitem']),
            'description' => $row['description'],
            'is_item_checked' => $row['is_item_checked']
        ]);        
    }
    return $items;
}

function getChecklistSubitems($rows) {
    $subitems = [];
    foreach ($rows as $row) {
        if (!isset($row['id_subitem']) or in_array($row['id_subitem'], array_column($subitems, 'id_subitem'))) {
            continue;
        }
        array_push($subitems, [
            'id_subitem' => $row['id_subitem'],
            'id_item' => $row['id_item'],
            'content' => $row['content'],
            'is_subitem_checked' => $row['is_subitem_checked']
        ]);
    }
    return $subitems;
}