function updateDateTime() {
    const datetimeEl = document.getElementById('datetime');
    if (!datetimeEl) return;

    const now = new Date();

    const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
    const months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let year = now.getFullYear();
    let month = months[now.getMonth()];
    let dayOfWeek = days[now.getDay()];

    let dateStr = `${hours}.${minutes}.${year} ${dayOfWeek}`;

    datetimeEl.textContent = dateStr;
}

setInterval(updateDateTime, 1000);
updateDateTime();