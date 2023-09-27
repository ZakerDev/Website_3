<?php



define('error', 'SomeValue');

$district = $_GET['district']; // Получите значение параметра 'district' из запроса
$val1 = $_GET['roadName']; // Получите значение параметра 'val1' из запроса
$selectedOption = $_GET['selectedOption']; // Получите значение параметра 'selectedOption' из запроса


try{
if (!empty($district) && !empty($val1) && !empty($selectedOption)) {
    // Постройте путь к файлу на основе параметров
    $filePath = 'C:\MAMP\htdocs\Roadsnew\\' . $district . '\\' . str_replace('–', '-', $val1) . '\\' . $selectedOption; // Замените на путь к вашему файлу таблицы
    try{
        if (file_exists($filePath)) {
            
            $fileContent = file_get_contents($filePath);
            $lines = explode("\n", $fileContent);
            
            // Проверка на наличие хотя бы одной строки данных
            if (count($lines) > 0) {
                $headerLine = $lines[0]; // Получение первой строки (заголовка)
                $columnNames = explode("\t", $headerLine); // Разделение заголовка по табуляции
                
                // Создание списков для каждого столбца
                $columnLists = array();
                for ($i = 0; $i < count($columnNames); $i++) {
                    $columnLists[] = array();
                }
                
                echo '<table border="1"><tr>';
                
                // Вывод названий столбцов
                foreach ($columnNames as $columnName) {
                    echo '<th>' . $columnName . '</th>';
                }
                
                echo '</tr>';
                
                // Вывод данных, начиная со второй строки
                for ($i = 1; $i < count($lines); $i++) {
                    echo '<tr>';
                    $line = $lines[$i];
                    
                    if (!empty(trim($line))) {
                        $rowData = explode("\t", $line); // Разбейте строку на столбцы
                        
                        // Вывод данных для каждого столбца и добавление их в соответствующий список
                        foreach ($rowData as $index => $data) {
                            echo '<td>' . $data . '</td>';
                            $columnLists[$index][] = $data; // Наполняем списки данными
                        }
                    }
                    
                    echo '</tr>';
                }
                
                echo '</table>';

            

            }
            
    } else {
        echo 'Файл не найден.';
    }
    }
    catch (Exception $e) {
        $errorMessage = $e->getMessage();
        error_log('Произошла ошибка: ' . $errorMessage, 0); // Запись ошибки в лог

        
    }
} else {
    echo 'Некорректные параметры запроса.';
}

}
catch (Exception $e) {
    error_log($e->getMessage()); // Записать сообщение об ошибке в лог
    echo 'Произошла ошибка: ' . $e->getMessage(); // Вернуть сообщение об ошибке клиенту
}

?>