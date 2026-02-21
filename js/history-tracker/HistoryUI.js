import {HistoryRepository} from './repository.js';
import {HistoryPresentation} from './presentation.js';

export const HistoryUI = {
    init() {
        if (!window.location.pathname.includes('history.html')) return;
        this.renderTables();
        this.bindEvents();
    },

    renderTables() {
        this.renderTable('session-history', HistoryRepository.getSessionHistory());
        this.renderTable('total-history', HistoryRepository.getTotalHistory());
    },

    renderTable(tableId, data) {
        const $table = $('#' + tableId);
        const $tbody = $table.find('tbody');
        $tbody.empty();

        const entries = Object.entries(data).sort(([, a], [, b]) => b.count - a.count);

        if (!entries.length) {
            $tbody.append('<tr><td colspan="3" class="no-data">Нет данных</td></tr>');
            return;
        }

        entries.forEach(([pageId, info]) => {
            const row = `<tr>
                <td>${HistoryPresentation.getPageDisplayName(pageId)}</td>
                <td>${info.count}</td>
                <td>${HistoryPresentation.formatDate(info.lastVisit)}</td>
            </tr>`;
            $tbody.append(row);
        });
    },

    bindEvents() {
        $('#clear-session').on('click', () => {
            if (confirm('Вы уверены, что хотите очистить историю текущего сеанса?')) {
                HistoryRepository.clearSessionHistory();
                this.renderTable('session-history', HistoryRepository.getSessionHistory());
                this.showMessage('История текущего сеанса очищена');
            }
        });

        $('#clear-total').on('click', () => {
            if (confirm('Вы уверены, что хотите очистить всю историю просмотров?')) {
                HistoryRepository.clearTotalHistory();
                this.renderTable('total-history', HistoryRepository.getTotalHistory());
                this.showMessage('Вся история просмотров очищена');
            }
        });
    },

    showMessage(msg) {
        const $el = $('<div class="history-message"></div>').text(msg).css({
            position: 'fixed',
            top: '20px',
            right: '20px',
            background: '#4CAF50',
            color: 'white',
            padding: '15px 20px',
            borderRadius: '5px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.3)',
            zIndex: 1000,
            animation: 'slideIn 0.3s ease'
        }).appendTo('body');

        setTimeout(() => $el.remove(), 3000);
    }
};