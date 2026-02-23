export const HistoryPresentation = {
    formatDate(timestamp) {
        try {
            const date = new Date(timestamp);
            return date.toLocaleString('ru-RU', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch {
            return 'Неизвестно';
        }
    },

    getPageDisplayName(pageId) {
        const pageNames = {
            'index.html': 'Главная страница',
            'about.html': 'Обо мне',
            'interests.html': 'Мои интересы',
            'study.html': 'Учёба',
            'gallery.html': 'Фотоальбом',
            'contacts.html': 'Контакты',
            'history.html': 'История просмотра',
            'test.html': 'Тест по физике'
        };
        return pageNames[pageId] || pageId;
    }
};