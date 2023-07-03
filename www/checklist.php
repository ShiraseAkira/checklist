<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/style.css">
    <title>Checklist</title>
    <script defer src="scripts/script.js"></script>
</head>
<body>

<?php
require_once 'boot.php';
require_once 'checklist_functions.php';

if(!isset($_SESSION['id_user'])) {
    header('Location: /');
} else { ?>
    <div class="wrapper">
        <header>
            <a href="/">Главная</a>
            <div>
                <div>
                    <h3>
                        <?= $_SESSION['display_name'] ?> 
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
    echo "<h2 class='checklist-title'>".getChecklistTitle()."</h2>";

    $stmt = getChecklistData();
    if ($stmt->rowCount() == 0) {
        echo "<h2 class='checklist-title'>Пустой чеклист</h2>";
    } else {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $items = getChecklistImtes($rows);
        $subitems = getChecklistSubitems($rows);

        echo "<ul class='list-item'>";
        foreach($items as $item) {    
            $state = $item['is_item_checked'] ? " checked" : "";
            echo "<li><div class='item-header'><label><input type='checkbox' data-id-item='{$item['id_item']}'$state>{$item['name']}</label>";
            if ($item['has_hideable']){
                echo "<button class='toggle'>+</button>";
            }
            echo "</div>";
            if ($item['has_hideable']){
                echo "<div class='item-content hide'>";
            }
            if (isset($item['description'])){
                echo "<p>{$item['description']}</p>";
            }                
            
            $item_id = $item['id_item'];
            $corr_subitems = array_filter($subitems, function($var) use ($item_id) {
                return ($var['id_item'] == $item_id);
            });

            if(!empty($corr_subitems)) {
                echo "<ul class='list-subitem'>";
                foreach($corr_subitems as $subitem){
                    $state = $subitem['is_subitem_checked'] ? " checked" : "";
                    echo "<li><label><input type='checkbox' data-id-subitem='{$subitem['id_subitem']}'$state>{$subitem['content']}</label></li>";
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
        </main>
    </div>
</body>
</html>