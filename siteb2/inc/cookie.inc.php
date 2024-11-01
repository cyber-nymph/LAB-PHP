<?php
// Инициализируем счетчик посещений
$visitCounter = 0;

// Проверяем, пришли ли куки по имени 'visitCounter'
if (isset($_COOKIE['visitCounter'])) {
    // Сохраняем значение куки в переменную $visitCounter
    $visitCounter = $_COOKIE['visitCounter'];
}

// Увеличиваем счетчик посещений
$visitCounter++;

// Инициализируем переменную для хранения последнего посещения
$lastVisit = "";

// Проверяем, пришли ли куки по имени 'lastVisit'
if (isset($_COOKIE['lastVisit'])) {
    // Форматируем дату последнего посещения
    $lastVisit = date('d-m-Y H:i:s', $_COOKIE['lastVisit']);
}

// Проверяем, был ли последний визит не сегодня
if (!isset($_COOKIE['lastVisit']) || date('d-m-Y', $_COOKIE['lastVisit']) != date('d-m-Y')) {
    // Устанавливаем куки 'visitCounter' со значением $visitCounter
    setcookie('visitCounter', $visitCounter, time() + 3600 * 24 * 30); // куки на 30 дней
    
    // Устанавливаем куки 'lastVisit' с текущей временной меткой
    setcookie('lastVisit', time(), time() + 3600 * 24 * 30); // куки на 30 дней
}
?>

