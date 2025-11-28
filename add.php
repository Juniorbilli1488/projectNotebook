<?php
// add.php - Функции добавления записей

// Функция для отображения формы добавления
function displayAddForm() {
    $message = '';
    $message_class = '';
    
    // Обрабатываем отправку формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button']) && $_POST['button'] == 'Добавить') {
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
            // Собираем данные из формы
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
            
            // Пытаемся добавить запись
            if (addContact($data)) {
                $message = 'Запись добавлена';
                $message_class = 'success';
            } else {
                $message = 'Ошибка: запись не добавлена';
                $message_class = 'error';
            }
        }
    }
    
    // Подготавливаем пустые значения для формы
    $row = [
        'surname' => '', 'name' => '', 'lastname' => '', 'gender' => '',
        'date' => '', 'phone' => '', 'location' => '', 'email' => '', 'comment' => ''
    ];
    $button = 'Добавить';
    
    // Начинаем формировать HTML
    $html = '<main>';
    
    // Выводим сообщение если есть
    if ($message) {
        $html .= "<div class='$message_class'>$message</div>";
    }
    
    // Подключаем форму
    ob_start();
    include 'form.php';
    $html .= ob_get_clean();
    
    $html .= '</main>';
    return $html;
}
?>