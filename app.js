const http = require('http');
const fs = require('fs');
const path = require('path');

const server = http.createServer((req, res) => {
    // Устанавливаем путь к папке с публичными ресурсами
    const publicPath = path.join(__dirname, 'public');

    // Получаем путь к запрошенному файлу
    const requestedFile = path.join(publicPath, req.url);

    // Проверяем, является ли запрошенный ресурс файлом
    fs.stat(requestedFile, (err, stats) => {
        if (err) {
            // Ошибка при получении информации о файле, возвращаем ошибку 404
            res.statusCode = 404;
            res.end('File not found');
        } else {
            if (stats.isDirectory()) {
                // Если это директория, попробуйте найти файл index.html внутри
                const indexPath = path.join(requestedFile, 'index.html');
                fs.access(indexPath, fs.constants.F_OK, (err) => {
                    if (err) {
                        // Файл index.html не найден, возвращаем ошибку 404
                        res.statusCode = 404;
                        res.end('File not found');
                    } else {
                        // Отправляем файл index.html клиенту
                        fs.createReadStream(indexPath).pipe(res);
                    }
                });
            } else {
                // Если это файл, отправляем его клиенту
                fs.createReadStream(requestedFile).pipe(res);
            }
        }
    });
});

const PORT = 80;

server.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});