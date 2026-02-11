$(document).ready(function() {
    HistoryTracker.init();
    
    if ($('#interests-content').length) {
        initInterestsManager();
    }

    if (window.location.pathname.includes('history.html')) {
        initHistoryManager();
    }

    function initInterestsManager() {
        const $content = $('#interests-content');
        
        const groups = [
            { title: 'Моё хобби', items: ['Видеоигры', 'Чтение', 'Программирование', 'Настольные игры'] },
            { title: 'Любимые книги', items: ['Война и мир', 'Три мушкетёра', 'Граф Монте-Кристо', '1984', 'Преступление и наказание'] },
            { title: 'Любимая музыка', items: ['Три дня дождя', 'Pyrokinesis', 'Playingtheangel', 'Queen', 'Daft Punk'] },
            { title: 'Любимые фильмы', items: ['Крёстный отец', 'Зелёная книга', 'Интерстеллар', 'Начало', 'Матрица'] }
        ];

        $.each(groups, function(index, group) {
            const $groupElement = createListGroup(group.title, group.items);
            $content.append($groupElement);
        });
    }

    function createListGroup(title, items) {
        const $groupContainer = $('<div class="list-group"></div>');
        
        const $groupTitle = $('<h3></h3>').text(title);
        $groupContainer.append($groupTitle);
        
        const $cardContainer = $('<div class="list-container"></div>');
        
        $.each(items, function(index, item) {
            const $card = $('<div class="item-card"></div>');
            const $cardTitle = $('<p></p>').text(item);
            
            $card.append($cardTitle);
            $cardContainer.append($card);
        });
        
        $groupContainer.append($cardContainer);
        return $groupContainer;
    }

    function initHistoryManager() {
        renderHistoryTables();
        bindHistoryEvents();
    }

    function renderHistoryTables() {
        renderSessionHistory();
        renderTotalHistory();
    }

    function renderSessionHistory() {
        const sessionHistory = HistoryTracker.getSessionHistory();
        renderHistoryTable('session-history', sessionHistory);
    }

    function renderTotalHistory() {
        const totalHistory = HistoryTracker.getTotalHistory();
        renderHistoryTable('total-history', totalHistory);
    }

    function renderHistoryTable(tableId, historyData) {
        const $table = $('#' + tableId);
        const $tbody = $table.find('tbody');
        
        $tbody.empty();
        
        const pages = Object.entries(historyData)
            .sort(([, a], [, b]) => b.count - a.count);
        
        if (pages.length === 0) {
            const $row = $('<tr></tr>')
                .html('<td colspan="3" class="no-data">Нет данных</td>');
            $tbody.append($row);
            return;
        }
        
        $.each(pages, function(index, [pageId, data]) {
            const $row = $('<tr></tr>')
                .html(`
                    <td>${HistoryTracker.getPageDisplayName(pageId)}</td>
                    <td>${data.count}</td>
                    <td>${HistoryTracker.formatDate(data.lastVisit)}</td>
                `);
            
            $tbody.append($row);
        });
    }

    function bindHistoryEvents() {
        $('#clear-session').on('click', function() {
            if (confirm('Вы уверены, что хотите очистить историю текущего сеанса?')) {
                HistoryTracker.clearSessionHistory();
                renderSessionHistory();
                showMessage('История текущего сеанса очищена');
            }
        });
        
        $('#clear-total').on('click', function() {
            if (confirm('Вы уверены, что хотите очистить всю историю просмотров?')) {
                HistoryTracker.clearTotalHistory();
                renderTotalHistory();
                showMessage('Вся история просмотров очищена');
            }
        });
    }

    function showMessage(message) {
        const $messageEl = $('<div class="history-message"></div>')
            .text(message)
            .css({
                position: 'fixed',
                top: '20px',
                right: '20px',
                background: '#4CAF50',
                color: 'white',
                padding: '15px 20px',
                borderRadius: '5px',
                boxShadow: '0 4px 12px rgba(0,0,0,0.3)',
                zIndex: '1000',
                animation: 'slideIn 0.3s ease'
            })
            .appendTo('body');
        
        setTimeout(function() {
            $messageEl.remove();
        }, 3000);
    }
});