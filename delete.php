<?php
// delete.php - Функции удаления записей

// Функция для отображения страницы удаления
function displayDeletePage() {
    // Получаем все контакты
    $contacts = getAllContacts();
    
    // Если контактов нет, выводим сообщение
    if (empty($contacts)) {
        return '<main><p>Нет контактов для удаления</p></main>';
    }
    
    $message = '';
    
    // Обрабатываем удаление
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);
        $contact_to_delete = getContact($delete_id);
        
        if ($contact_to_delete && deleteContact($delete_id)) {
            $surname = htmlspecialchars($contact_to_delete['surname']);
            $message = "<div class='success'>Запись с фамилией $surname удалена</div>";
            
            // Обновляем список контактов после удаления
            $contacts = getAllContacts();
        }
    }
    
    // Начинаем формировать HTML
    $html = '<main>';
    
    // Выводим сообщение если есть
    if ($message) {
        $html .= $message;
    }
    
    // Создаем список контактов для удаления
    $html .= '<div class="div-edit">';
    foreach ($contacts as $contact) {
        $display_name = htmlspecialchars($contact['surname'] . ' ' . $contact['name'] . ' ' . 
                         ($contact['lastname'] ? mb_substr($contact['lastname'], 0, 1) . '.' : ''));
        $html .= "<a href='index.php?page=delete&delete_id={$contact['id']}'>$display_name</a><br>";
    }
    $html .= '</div>';
    
    $html .= '</main>';
    return $html;
}
?>