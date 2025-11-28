<?php
// Глобальные переменные для подключения к БД
$pdo = null;

// Функция подключения к базе данных
function connectDatabase() {
    global $pdo;
    
    try {
        // Данные для подключения к MySQL
        $host = 'localhost';
        $dbname = 'contacts_db';
        $username = 'root';
        $password = '';
        
        // Сначала подключаемся без выбора базы данных
        $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Создаем базу данных если она не существует
        createDatabase();
        
        // Теперь подключаемся к конкретной базе данных
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Создаем таблицу если она не существует
        createTable();
        
    } catch(PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}

// Функция создания базы данных
function createDatabase() {
    global $pdo;
    try {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS contacts_db");
    } catch(PDOException $e) {
        die("Ошибка создания базы данных: " . $e->getMessage());
    }
}

// Функция создания таблицы
function createTable() {
    global $pdo;
    
    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT PRIMARY KEY AUTO_INCREMENT,
        surname VARCHAR(100) NOT NULL,
        name VARCHAR(100) NOT NULL,
        lastname VARCHAR(100),
        gender VARCHAR(10),
        date DATE,
        phone VARCHAR(20),
        location TEXT,
        email VARCHAR(100),
        comment TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    try {
        $pdo->exec($sql);
    } catch(PDOException $e) {
        die("Ошибка создания таблицы: " . $e->getMessage());
    }
}

// Функция получения контактов с сортировкой и пагинацией
function getContacts($sort = 'id', $limit = 10, $offset = 0) {
    global $pdo;
    
    // Защита от SQL инъекций - белый список полей сортировки
    $allowed_sorts = ['id', 'surname', 'date'];
    $sort = in_array($sort, $allowed_sorts) ? $sort : 'id';
    
    $sql = "SELECT * FROM contacts ORDER BY $sort LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Функция получения общего количества контактов
function getTotalContacts() {
    global $pdo;
    $sql = "SELECT COUNT(*) FROM contacts";
    return $pdo->query($sql)->fetchColumn();
}

// Функция добавления нового контакта
function addContact($data) {
    global $pdo;
    
    $sql = "INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment) 
            VALUES (:surname, :name, :lastname, :gender, :date, :phone, :location, :email, :comment)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}

// Функция получения контакта по ID
function getContact($id) {
    global $pdo;
    
    $sql = "SELECT * FROM contacts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Функция обновления контакта
function updateContact($id, $data) {
    global $pdo;
    
    $sql = "UPDATE contacts SET 
            surname = :surname, name = :name, lastname = :lastname, 
            gender = :gender, date = :date, phone = :phone, 
            location = :location, email = :email, comment = :comment 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $data['id'] = $id;
    return $stmt->execute($data);
}

// Функция удаления контакта
function deleteContact($id) {
    global $pdo;
    
    $sql = "DELETE FROM contacts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Функция получения всех контактов для редактирования/удаления
function getAllContacts($sort = 'surname') {
    global $pdo;
    
    $sql = "SELECT * FROM contacts ORDER BY $sort, name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Инициализация подключения к базе данных
connectDatabase();
?>