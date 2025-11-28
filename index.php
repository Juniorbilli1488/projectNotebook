<?php
// Подключаем все необходимые модули
require_once 'database.php';
require_once 'menu.php';
require_once 'viewer.php'; 
require_once 'add.php';
require_once 'edit.php';
require_once 'delete.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записная книжка — Мороз Артем Александрович 243-323</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // Выводим меню
    echo createMenu();
    
    // Определяем какую страницу показывать
    $page = isset($_GET['page']) ? $_GET['page'] : 'view';
    
    // Отображаем соответствующий контент
    switch ($page) {
        case 'add':
            echo displayAddForm();
            break;
            
        case 'edit':
            echo displayEditForm();
            break;
            
        case 'delete':
            echo displayDeletePage();
            break;
            
        case 'view':
        default:
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
            $page_num = isset($_GET['page_num']) ? intval($_GET['page_num']) : 1;
            echo displayContacts($sort, $page_num);
            break;
    }
    ?>
    
    <footer>
    </footer>
</body>
</html>