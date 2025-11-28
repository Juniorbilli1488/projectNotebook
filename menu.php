<?php
// menu.php - Функции меню

// Функция для создания меню
function createMenu() {
    // Получаем текущую страницу из GET параметра
    $current_page = isset($_GET['page']) ? $_GET['page'] : 'view';
    $current_sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
    
    // Основные пункты меню
    $menu_items = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи', 
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    $menu_html = '<header>';
    
    // Создаем основные пункты меню
    foreach ($menu_items as $page => $title) {
        $class = ($current_page == $page) ? 'select' : '';
        $menu_html .= "<a href='index.php?page=$page' class='$class'>$title</a>";
    }
    
    $menu_html .= '</header>';
    
    // Если активен просмотр, добавляем подменю для сортировки
    if ($current_page == 'view') {
        $sort_items = [
            'id' => 'По порядку добавления',
            'surname' => 'По фамилии',
            'date' => 'По дате рождения'
        ];
        
        $menu_html .= '<div class="submenu">';
        foreach ($sort_items as $sort => $title) {
            $class = ($current_sort == $sort) ? 'select' : '';
            $menu_html .= "<a href='index.php?page=view&sort=$sort' class='$class'>$title</a>";
        }
        $menu_html .= '</div>';
    }
    
    return $menu_html;
}
?>