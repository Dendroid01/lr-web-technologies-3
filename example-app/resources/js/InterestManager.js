$(document).ready(function () {
    if ($('#interests-content').length) {
        initInterestsManager();
    }

    function initInterestsManager() {
        const $content = $('#interests-content');

        const groups = [
            {
                title: 'Моё хобби',
                items: ['Видеоигры', 'Чтение', 'Программирование', 'Настольные игры']
            },
            {
                title: 'Любимые книги',
                items: ['Война и мир', 'Три мушкетёра', 'Граф Монте-Кристо', '1984', 'Преступление и наказание']
            },
            {
                title: 'Любимая музыка',
                items: ['Три дня дождя', 'Pyrokinesis', 'Playingtheangel', 'Queen', 'Daft Punk']
            },
            {
                title: 'Любимые фильмы',
                items: ['Крёстный отец', 'Зелёная книга', 'Интерстеллар', 'Начало', 'Матрица']
            }
        ];

        $.each(groups, function (index, group) {
            const $groupElement = createListGroup(group.title, group.items);
            $content.append($groupElement);
        });
    }

    function createListGroup(title, items) {
        const $groupContainer = $('<div class="list-group"></div>');
        const $groupTitle = $('<h3></h3>').text(title);
        $groupContainer.append($groupTitle);

        const $cardContainer = $('<div class="list-container"></div>');

        $.each(items, function (index, item) {
            const $card = $('<div class="item-card"></div>');
            const $cardTitle = $('<p></p>').text(item);
            $card.append($cardTitle);
            $cardContainer.append($card);
        });

        $groupContainer.append($cardContainer);
        return $groupContainer;
    }
});