// resources/js/sidebar-dropdown.js

export function initSidebarDropdown() {
    // Предварительно скрываем все дропдауны
    $('.dropdown-menu').css({
        'opacity': '0',
        'visibility': 'hidden',
        'transform': 'scale(0.95)',
        'transition': 'opacity 0.2s ease, visibility 0.2s ease, transform 0.2s ease'
    });

    $('.dropdown').hover(
        function() {
            const $dropdown = $(this);
            const $menu = $dropdown.find('.dropdown-menu');
            const $link = $dropdown.find('.dropdown-link');

            // Получаем позицию кнопки
            const linkOffset = $link.offset();
            const linkHeight = $link.outerHeight();
            const linkWidth = $link.outerWidth();

            // Устанавливаем позицию ДО показа (скрыто)
            $menu.css({
                'position': 'fixed',
                'top': linkOffset.top,
                'left': linkOffset.left + linkWidth,
                'margin-top': '0',
                'display': 'block'
            });

            // Принудительное перерисовывание перед показом
            $menu[0].offsetHeight;

            // Показываем с анимацией
            $menu.css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'scale(1)'
            });

            if (!$link.hasClass('active')) {
                applyHoverStyles($dropdown, $link);
            }
        },
        function() {
            const $dropdown = $(this);
            const $menu = $dropdown.find('.dropdown-menu');
            const $link = $dropdown.find('.dropdown-link');

            // Скрываем с анимацией
            $menu.css({
                'opacity': '0',
                'visibility': 'hidden',
                'transform': 'scale(0.95)'
            });

            if (!$link.hasClass('active')) {
                removeHoverStyles($dropdown, $link);
            }
        }
    );

    // Обработка пунктов меню
    $('.dropdown-menu a').hover(
        function() {
            const $link = $(this);
            if (!$link.hasClass('active')) {
                applyDropdownItemHover($link);
            }
        },
        function() {
            const $link = $(this);
            if (!$link.hasClass('active')) {
                removeDropdownItemHover($link);
            }
        }
    );

    // Обновление позиции при скролле
    let scrollTimer;
    $(window).on('scroll', function() {
        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(function() {
            $('.dropdown .dropdown-menu.active, .dropdown .dropdown-menu[style*="visibility: visible"]').each(function() {
                const $menu = $(this);
                const $parent = $menu.closest('.dropdown');
                const $link = $parent.find('.dropdown-link');

                if ($menu.css('visibility') === 'visible') {
                    const linkOffset = $link.offset();
                    $menu.css('top', linkOffset.top);
                }
            });
        }, 10);
    });

    // Функции стилизации
    function applyHoverStyles($item, $link) {
        if (!$item.data('originalBackground')) {
            $item.data('originalBackground', $item.css('backgroundColor'));
            $link.data('originalBackground', $link.css('backgroundColor'));
        }
        $item.css('backgroundColor', 'rgba(255, 255, 255, 0.08)');
        $link.css('backgroundColor', 'rgba(255, 255, 255, 0.08)');
    }

    function removeHoverStyles($item, $link) {
        $item.css('backgroundColor', $item.data('originalBackground') || '');
        $link.css('backgroundColor', $link.data('originalBackground') || '');
    }

    function applyDropdownItemHover($link) {
        if (!$link.data('originalBackground')) {
            $link.data('originalBackground', $link.css('backgroundColor'));
            $link.data('originalPadding', $link.css('paddingLeft'));
        }
        $link.css({
            'backgroundColor': 'rgba(255, 255, 255, 0.1)',
            'paddingLeft': '25px'
        });
    }

    function removeDropdownItemHover($link) {
        $link.css({
            'backgroundColor': $link.data('originalBackground') || '',
            'paddingLeft': $link.data('originalPadding') || ''
        });
    }
}
