export const HistoryStorage = {
    SESSION_STORAGE_KEY: 'session_page_visits',
    TOTAL_STORAGE_KEY: 'total_page_visits',

    init() {
        this.trackPageVisit();
    },

    trackPageVisit() {
        const currentPage = this.getCurrentPage();
        const timestamp = new Date().toISOString();

        this.updateSessionHistory(currentPage, timestamp);
        this.updateTotalHistory(currentPage, timestamp);
    },

    getCurrentPage() {
        const path = window.location.pathname;
        const page = path.split('/').pop() || 'index.html';
        return page;
    },

    updateSessionHistory(page, timestamp) {
        let sessionHistory = this.getSessionHistory();

        if (!sessionHistory[page]) {
            sessionHistory[page] = {
                count: 0,
                lastVisit: timestamp
            };
        }

        sessionHistory[page].count++;
        sessionHistory[page].lastVisit = timestamp;

        this.saveSessionHistory(sessionHistory);
    },

    updateTotalHistory(page, timestamp) {
        let totalHistory = this.getTotalHistory();

        if (!totalHistory[page]) {
            totalHistory[page] = {
                count: 0,
                lastVisit: timestamp
            };
        }

        totalHistory[page].count++;
        totalHistory[page].lastVisit = timestamp;

        this.saveTotalHistory(totalHistory);
    },

    getSessionHistory() {
        try {
            const history = sessionStorage.getItem(this.SESSION_STORAGE_KEY);
            return history ? JSON.parse(history) : {};
        } catch (error) {
            return {};
        }
    },

    saveSessionHistory(history) {
        try {
            sessionStorage.setItem(this.SESSION_STORAGE_KEY, JSON.stringify(history));
        } catch (error) {
        }
    },

    getTotalHistory() {
        try {
            const history = localStorage.getItem(this.TOTAL_STORAGE_KEY);
            return history ? JSON.parse(history) : {};
        } catch (error) {
            return {};
        }
    },

    saveTotalHistory(history) {
        try {
            localStorage.setItem(this.TOTAL_STORAGE_KEY, JSON.stringify(history));
        } catch (error) {
        }
    },

    clearSessionHistory() {
        try {
            sessionStorage.removeItem(this.SESSION_STORAGE_KEY);
        } catch (error) {
        }
    },

    clearTotalHistory() {
        try {
            localStorage.removeItem(this.TOTAL_STORAGE_KEY);
        } catch (error) {
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
    },

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
        } catch (error) {
            return 'Неизвестно';
        }
    }
};