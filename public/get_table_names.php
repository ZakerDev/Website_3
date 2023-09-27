<?php

//на вход поставить аргументы название дороги и район.
// ищем папку с названием дороги
// Оттуда берем список
$district = $_GET['district'];
$roadName = $_GET['roadName'];
try{
function getTableNames($district, $roadName) {
    try{
    // Формируем путь к папке с таблицами на основе района и названия дороги
    $folderPath = 'C:\MAMP\htdocs\Roadsnew\\' . $district . '\\' . str_replace('–', '-', $roadName);
    
    #здесь я хочу добавить вывод в консоль $folderPath
    

    if (is_dir($folderPath)) {
        $tableNames = [];

        // Получаем список файлов в папке
        $files = scandir($folderPath);
        
        

        // Проходимся по файлам и добавляем их наименования в массив
        foreach ($files as $file) {
            if (is_file($folderPath . '/' . $file)) {
                $tableNames[] = $file;
            }
        }

        // Отправляем массив наименований в формате JSON
        return json_encode($tableNames);
    } else {
        return json_encode([$folderPath, scandir($folderPath) ]); // Если папка не существует, возвращаем пустой массив
    }
    }
    catch(error){
        error_log(error);
    }
}
}
catch(error){
    error_log(error);
}

// Вызываем функцию getTableNames с полученными параметрами
$tableNames = getTableNames($district, $roadName);

// Отправляем массив наименований в формате JSON
echo $tableNames;



?>