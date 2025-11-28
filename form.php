<?php
// form.php - Форма для добавления/редактирования
?>
<form name="form_add" method="post">
    <div class="column">
        <div class="add">
            <label>Фамилия</label> 
            <input type="text" name="surname" placeholder="Фамилия" value="<?= htmlspecialchars($row['surname'] ?? '') ?>" required>
        </div>
        <div class="add">
            <label>Имя</label> 
            <input type="text" name="name" placeholder="Имя" value="<?= htmlspecialchars($row['name'] ?? '') ?>" required>
        </div>
        <div class="add">
            <label>Отчество</label> 
            <input type="text" name="lastname" placeholder="Отчество" value="<?= htmlspecialchars($row['lastname'] ?? '') ?>">
        </div>
        <div class="add">
            <label>Пол</label> 
            <select name="gender">
                <option value="">Выберите пол</option>
                <option value="мужской" <?= (isset($row['gender']) && $row['gender'] == 'мужской') ? 'selected' : '' ?>>мужской</option>
                <option value="женский" <?= (isset($row['gender']) && $row['gender'] == 'женский') ? 'selected' : '' ?>>женский</option>
            </select>
        </div>
        <div class="add">
            <label>Дата рождения</label> 
            <input type="date" name="date" value="<?= $row['date'] ?? '' ?>">
        </div>
        <div class="add">
            <label>Телефон</label> 
            <input type="text" name="phone" placeholder="Телефон" value="<?= htmlspecialchars($row['phone'] ?? '') ?>">
        </div>
        <div class="add">
            <label>Адрес</label> 
            <input type="text" name="location" placeholder="Адрес" value="<?= htmlspecialchars($row['location'] ?? '') ?>"> 
        </div>
        <div class="add">
            <label>Email</label> 
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($row['email'] ?? '') ?>">
        </div>
        <div class="add">
            <label>Комментарий</label> 
            <textarea name="comment" placeholder="Краткий комментарий"><?= htmlspecialchars($row['comment'] ?? '') ?></textarea>
        </div>
    
        <button type="submit" value="<?= $button ?>" name="button" class="form-btn"><?= $button ?></button>
    </div>
</form>