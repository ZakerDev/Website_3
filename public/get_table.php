<?php

//на вход поставить аргументы название дороги и район.
// ищем папку с названием дороги
// Оттуда берем список

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
            // Прочитайте содержимое файла таблицы
            $fileContent = file_get_contents($filePath);
            
            // Разбейте содержимое файла на строки
            $lines = explode("\n", $fileContent);
            error_log($lines[1]);
            // Создайте список для хранения значений из первого столбца
            $valuesList = array();
            
            $columnList_2 = array();
            $columnList_3 = array();
            $columnList_4 = array();
            $columnList_5 = array();
            $columnList_6 = array();
            $columnList_7 = array();
            // Пройдитесь по каждой строке и извлеките значение из первого столбца
            for ($i = 1; $i < count($lines); $i++) {
                $line = $lines[$i];
                if (!empty(trim($line))){

                
                    $columns = explode("\t", $line); // Разбейте строку на столбцы
                    if (isset($columns[0]) && isset($columns[1])) {
                        $startLocation = trim($columns[0]); // Получите значение из первого столбца
                        $endLocation = trim($columns[1]); // Получите значение из второго столбца
                        $column2 = trim($columns[2]);
                        $column3 = trim($columns[3]);
                        $column4 = trim($columns[4]);
                        $column5 = trim($columns[5]);
                        if ($startLocation!=' ' && $endLocation!=' '){
                        $valuesList[] = $startLocation;
                        $valuesList[] = $endLocation;
                        $columnList_2[]=$column2;
                        $columnList_3[]=$column3;
                        $columnList_4[]=$column4;
                        $columnList_5[]=$column5;
                    }
                        
                    }
                }
            }
            $exit_list=[$valuesList,$columnList_2,$columnList_3,$columnList_4,$columnList_5];
            
            // Отправьте список на клиентскую сторону в формате JSON
            header('Content-Type: text/plain');
            echo implode("\n", $exit_list);
            exit;
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