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
} else { ?>
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
    $stmt = pdo()->prepare("SELECT `name` FROM `checklists` WHERE `id_checklist` = :id_checklist");
    $stmt->execute(['id_checklist' => $_GET['id_checklist']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 0) {
        header('Location: /');
        die;
    }
    echo "<h2 class='checklist-title'>".$rows[0]['name']."</h2>";

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
    if ($stmt->rowCount() == 0) {
        echo "<h2 class='checklist-title'>Пустой чеклист</h2>";
    } else {
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



        echo "<ul>";
        foreach($items as $item) {    
            echo "<li class='list-item' data-id-item='".$item['id_item']."'>";
            echo "<div><label><input type='checkbox'>".$item['name']."</label>";
            if ($item['has_hideable']){
                echo "<button>+</button>";
            }
            echo "</div>";
            if ($item['has_hideable']){
                echo "<div class='item-content hide'>";
            }
            if (isset($item['description'])){
                echo "<p>".$item['description']."</p>";
            }                
            
            $item_id = $item['id_item'];
            $corr_subitems = array_filter($subitems, function($var) use ($item_id) {
                return ($var['id_item'] == $item_id);
            });

            if(!empty($corr_subitems)) {
                echo "<ul>";
                foreach($corr_subitems as $subitem){
                    echo "<li class='list-subitem' data-id-subitem='".$subitem['id_subitem']."'>";
                    echo "<label><input type='checkbox'>".$subitem['content']. "</label>";
                    echo "</li>"; 
                }
                echo "</ul>";
            }
            if ($item['has_hideable']){
                echo "</div>";
            }
            echo "</li>"; 
        }
        echo "</ul>";
    }
}
?>

</body>
</html>