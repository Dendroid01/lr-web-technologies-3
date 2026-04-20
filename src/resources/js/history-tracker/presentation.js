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
            '/': 'Главная страница',
            '': 'Главная страница',
            'index.html': 'Главная страница',
            'index': 'Главная страница',
            'about': 'Обо мне',
            'interests': 'Мои интересы',
            'study': 'Учёба',
            'gallery': 'Фотоальбом',
            'contacts': 'Контакты',
            'history': 'История просмотра',
            'test': 'Тест по физике'
        };
        return pageNames[pageId] || pageId;
    }
};
