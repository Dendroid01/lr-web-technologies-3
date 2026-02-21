export const HistoryRepository = {
    SESSION_KEY: 'session_page_visits',
    TOTAL_KEY: 'total_page_visits',

    getSessionHistory() {
        try {
            const history = sessionStorage.getItem(this.SESSION_KEY);
            return history ? JSON.parse(history) : {};
        } catch {
            return {};
        }
    },

    saveSessionHistory(history) {
        try {
            sessionStorage.setItem(this.SESSION_KEY, JSON.stringify(history));
        } catch {}
    },

    clearSessionHistory() {
        try {
            sessionStorage.removeItem(this.SESSION_KEY);
        } catch {}
    },

    getTotalHistory() {
        try {
            const history = localStorage.getItem(this.TOTAL_KEY);
            return history ? JSON.parse(history) : {};
        } catch {
            return {};
        }
    },

    saveTotalHistory(history) {
        try {
            localStorage.setItem(this.TOTAL_KEY, JSON.stringify(history));
        } catch {}
    },

    clearTotalHistory() {
        try {
            localStorage.removeItem(this.TOTAL_KEY);
        } catch {}
    }
};