<?php
// edit.php - Функции редактирования записей

// Функция для отображения формы редактирования
function displayEditForm() {
    // Получаем ID выбранного контакта
    $selected_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // Получаем все контакты для списка
    $contacts = getAllContacts();
    
    // Если контактов нет, выводим сообщение
    if (empty($contacts)) {
        return '<main><p>Нет контактов для редактирования</p></main>';
    }
    
    // Если ID не выбран, берем первый контакт
    if ($selected_id == 0) {
        $selected_id = $contacts[0]['id'];
    }
    
    $message = '';
    $message_class = '';
    
    // Обрабатываем отправку формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button']) && $_POST['button'] == 'Обновить') {
        // Валидация обязательных полей
        if (empty($_POST['surname']) || empty($_POST['name'])) {
            $message = 'Ошибка: Фамилия и Имя обязательны для заполнения';
            $message_class = 'error';
        } 
        // Валидация email
        elseif (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = 'Ошибка: Неверный формат email';
            $message_class = 'error';
        }
        else {
            $data = [
                'surname' => trim($_POST['surname'] ?? ''),
                'name' => trim($_POST['name'] ?? ''),
                'lastname' => trim($_POST['lastname'] ?? ''),
                'gender' => $_POST['gender'] ?? '',
                'date' => $_POST['date'] ?? '',
                'phone' => trim($_POST['phone'] ?? ''),
                'location' => trim($_POST['location'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'comment' => trim($_POST['comment'] ?? '')
            ];
            
            // Очистка от HTML тегов
            $data['surname'] = strip_tags($data['surname']);
            $data['name'] = strip_tags($data['name']);
            $data['lastname'] = strip_tags($data['lastname']);
            $data['comment'] = strip_tags($data['comment']);
            
            if (updateContact($selected_id, $data)) {
                $message = 'Запись обновлена';
                $message_class = 'success';
            } else {
                $message = 'Ошибка: запись не обновлена';
                $message_class = 'error';
            }
        }
    }
    
    // Получаем данные выбранного контакта
    $current_contact = getContact($selected_id);
    $button = 'Обновить';
    
    // Начинаем формировать HTML
    $html = '<main>';
    
    // Выводим сообщение если есть
    if ($message) {
        $html .= "<div class='$message_class'>$message</div>";
    }
    
    // Создаем список контактов для выбора
    $html .= '<div class="div-edit">';
    foreach ($contacts as $contact) {
        $class = ($contact['id'] == $selected_id) ? 'currentRow' : '';
        $display_name = htmlspecialchars($contact['surname'] . ' ' . $contact['name'] . ' ' . $contact['lastname']);
        $html .= "<a href='index.php?page=edit&id={$contact['id']}' class='$class'>$display_name</a><br>";
    }
    $html .= '</div>';
    
    // Подключаем форму с данными текущего контакта
    ob_start();
    $row = $current_contact;
    include 'form.php';
    $html .= ob_get_clean();
    
    $html .= '</main>';
    return $html;
}
?>