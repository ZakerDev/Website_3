const http = require('http');
const url = require('url');
const fs = require('fs');

// Создаем HTTP-сервер
const server = http.createServer((req, res) => {
  // Разбираем URL-запроса
  const parsedUrl = url.parse(req.url, true);
  const district = parsedUrl.query.district;
  const roadName = parsedUrl.query.roadName;

  try {
    function getTableNames(district, roadName) {
      try {
        // Формируем путь к папке с таблицами на основе района и названия дороги
        const folderPath = `C:\\MAMP\\htdocs\\Roadsnew\\${district}\\${roadName.replace(/–/g, '-')}`;
        
        // Здесь можно добавить вывод в консоль
        console.log(folderPath);

        if (fs.existsSync(folderPath)) {
          const tableNames = [];

          // Получаем список файлов в папке
          const files = fs.readdirSync(folderPath);

          // Проходимся по файлам и добавляем их наименования в массив
          files.forEach((file) => {
            const filePath = `${folderPath}/${file}`;
            if (fs.statSync(filePath).isFile()) {
              tableNames.push(file);
            }
          });

          // Отправляем массив наименований в формате JSON
          res.setHeader('Content-Type', 'application/json');
          res.end(JSON.stringify(tableNames));
        } else {
          // Если папка не существует, возвращаем пустой массив
          res.setHeader('Content-Type', 'application/json');
          res.end(JSON.stringify([folderPath, fs.readdirSync(folderPath)]));
        }
      } catch (error) {
        console.error(error);
        res.statusCode = 500;
        res.end('Internal Server Error');
      }
    }

    // Вызываем функцию getTableNames с полученными параметрами
    const tableNames = getTableNames(district, roadName);

    // Отправляем массив наименований в формате JSON
    res.setHeader('Content-Type', 'application/json');
    res.end(JSON.stringify(tableNames));
  } catch (error) {
    console.error(error);
    res.statusCode = 500;
    res.end('Internal Server Error');
  }
});

const PORT = 3000;

// Запускаем сервер на порту 3000
server.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});