import { HistoryRepository } from './repository.js';

export const HistoryTracker = {
    trackPageVisit(page) {
        const timestamp = new Date().toISOString();
        this.updateSessionHistory(page, timestamp);
        this.updateTotalHistory(page, timestamp);
    },

    updateSessionHistory(page, timestamp) {
        const sessionHistory = HistoryRepository.getSessionHistory();

        if (!sessionHistory[page]) {
            sessionHistory[page] = { count: 0, lastVisit: timestamp };
        }

        sessionHistory[page].count++;
        sessionHistory[page].lastVisit = timestamp;

        HistoryRepository.saveSessionHistory(sessionHistory);
    },

    updateTotalHistory(page, timestamp) {
        const totalHistory = HistoryRepository.getTotalHistory();

        if (!totalHistory[page]) {
            totalHistory[page] = { count: 0, lastVisit: timestamp };
        }

        totalHistory[page].count++;
        totalHistory[page].lastVisit = timestamp;

        HistoryRepository.saveTotalHistory(totalHistory);
    },

    getCurrentPage() {
        const path = window.location.pathname;
        return path.split('/').pop() || 'index.html';
    }
};