<?php
/* Основные настройки */
// Основные настройки
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gbook');

// Установим соединение с базой данных
$connection = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

// Проверка соединения
if (!$connection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

/* Основные настройки */

/* Сохранение записи в БД */
// Сохранение записи в БД
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы и фильтруем их
    $name = mysqli_real_escape_string($connection, trim($_POST['name']));
    $email = mysqli_real_escape_string($connection, trim($_POST['email']));
    $msg = mysqli_real_escape_string($connection, trim($_POST['msg']));

    // Проверяем, что все поля заполнены
    if (!empty($name) && !empty($email) && !empty($msg)) {
        // Формируем SQL-запрос
        $query = "INSERT INTO msgs (name, email, msg) VALUES ('$name', '$email', '$msg')";

        // Выполняем запрос
        if (mysqli_query($connection, $query)) {
            echo "Запись успешно добавлена!";
        } else {
            echo "Ошибка при добавлении записи: " . mysqli_error($connection);
        }
    } else {
        echo "Пожалуйста, заполните все поля.";
    }
}

/* Сохранение записи в БД */

/* Удаление записи из БД */
// Удаление записи из БД
if (isset($_GET['del'])) {
    // Получаем id записи для удаления
    $del = (int)$_GET['del'];  // Приводим значение к целому числу для предотвращения SQL-инъекций

    // Формируем SQL-запрос для удаления записи
    $query = "DELETE FROM msgs WHERE id = $del";

    // Выполняем запрос
    if (mysqli_query($connection, $query)) {
        echo "<p>Запись успешно удалена.</p>";
    } else {
        echo "<p>Ошибка при удалении записи: " . mysqli_error($connection) . "</p>";
    }
}

/* Удаление записи из БД */
?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
Имя: <br /><input type="text" name="name" /><br />
Email: <br /><input type="text" name="email" /><br />
Сообщение: <br /><textarea name="msg"></textarea><br />

<br />

<input type="submit" value="Отправить!" />

</form>
<?php
/* Вывод записей из БД */
// Вывод записей из БД
$query = "SELECT id, name, email, msg, UNIX_TIMESTAMP(datetime) as dt FROM msgs ORDER BY id DESC";
$result = mysqli_query($connection, $query);

// Проверяем, если запрос выполнен успешно
if ($result) {
    // Получаем количество записей
    $num_rows = mysqli_num_rows($result);
    echo "<p>Всего записей в гостевой книге: $num_rows</p>";

    // Выводим все сообщения
    while ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['name']);  // Экранируем данные
        $email = htmlspecialchars($row['email']);
        $msg = nl2br(htmlspecialchars($row['msg']));  // Переводим новые строки в <br />
        $datetime = date("d-m-Y в H:i", $row['dt']);  // Форматируем дату

        // Выводим информацию о записи
        echo "<p><a href='mailto:$email'>$name</a> $datetime написал(а)<br />$msg</p>";

        // Ссылка для удаления записи
        echo "<p align='right'>
                <a href='http://localhost/siteb2/index.php?id=gbook&del=" . $row['id'] . "'>Удалить</a>
              </p>";
    }
} else {
    echo "Ошибка при выборке данных: " . mysqli_error($connection);
}

// Закрытие соединения с базой данных
mysqli_close($connection);

/* Вывод записей из БД */
?>