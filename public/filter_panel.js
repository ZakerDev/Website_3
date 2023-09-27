const filterBtn = document.getElementById('filterBtn');
const filterPanel = document.getElementById('filterPanel');
const closeFilterBtn = document.getElementById('closeFilterBtn');
const mapContainer = document.querySelector('.map-container');

filterBtn.addEventListener('click', () => {
    filterPanel.classList.add('active'); // Добавляем класс active к панели
    mapContainer.classList.add('active'); // Добавляем класс active к контейнеру карты
});

closeFilterBtn.addEventListener('click', () => {
    filterPanel.classList.remove('active'); // Убираем класс active у панели
    mapContainer.classList.remove('active'); // Убираем класс active у контейнера карты
});