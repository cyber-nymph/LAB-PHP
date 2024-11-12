<?php
// Путь к файлу журнала
$file = __DIR__ . '/../log/' . PATH_LOG;

// Проверка существования файла журнала
if (file_exists($file)) {
    // Получаем содержимое файла в виде массива строк
    $logData = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Если массив не пустой, выводим данные
    if (!empty($logData)) {
        echo '<ul>';
        // Проходим по каждой строке журнала
        foreach ($logData as $logEntry) {
            // Разделяем строку по разделителю "|", если нужно форматировать вывод
            list($dt, $page, $ref) = explode('|', $logEntry);

            // Выводим в удобочитаемом формате
            echo "<li>$dt - $page -> $ref</li>";
        }
        echo '</ul>';
    } else {
        echo '<p>Журнал пуст.</p>';
    }
} else {
    echo '<p>Файл журнала не найден.</p>';
}
?>
