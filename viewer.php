<?php
// viewer.php - Функции просмотра контактов

// Функция для отображения контактов в виде таблицы
function displayContacts($sort = 'id', $page = 1) {
    // Количество записей на странице
    $limit = 10;
    $offset = ($page - 1) * $limit;
    
    // Получаем контакты из базы данных
    $contacts = getContacts($sort, $limit, $offset);
    $total_contacts = getTotalContacts();
    $total_pages = ceil($total_contacts / $limit);
    
    $html = '<main>';
    
    // Если контактов нет, выводим сообщение
    if (empty($contacts)) {
        $html .= '<p>Нет контактов для отображения</p>';
        return $html;
    }
    
    // Создаем таблицу
    $html .= '<table>';
    $html .= '<tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Пол</th>
                <th>Дата рождения</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Email</th>
                <th>Комментарий</th>
              </tr>';
    
    // Заполняем таблицу данными
    foreach ($contacts as $contact) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($contact['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['lastname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['gender']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['date']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['location']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['comment']) . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    // Создаем пагинацию если страниц больше одной
    if ($total_pages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? 'style="font-weight: bold;"' : '';
            $html .= "<a href='index.php?page=view&sort=$sort&page_num=$i' $active>$i</a> ";
        }
        $html .= '</div>';
    }
    
    $html .= '</main>';
    return $html;
}
?>