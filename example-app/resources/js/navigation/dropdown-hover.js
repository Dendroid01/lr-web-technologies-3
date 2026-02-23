export function initDropdownHover() {
    $('.dropdown').hover(
        function () {
            $(this).find('.dropdown-menu').addClass('active');
        },
        function () {
            $(this).find('.dropdown-menu').removeClass('active');
        }
    );

    $('header nav > ul > li').hover(
        function () {
            const $item = $(this);
            const $link = $item.find('a').first();
            if (!$link.hasClass('active')) applyHoverStyles($item, $link);
        },
        function () {
            const $item = $(this);
            const $link = $item.find('a').first();
            if (!$link.hasClass('active')) removeHoverStyles($item, $link);
        }
    );

    $('.dropdown-menu a').hover(
        function () {
            const $link = $(this);
            if (!$link.hasClass('active')) applyDropdownItemHover($link);
        },
        function () {
            const $link = $(this);
            if (!$link.hasClass('active')) removeDropdownItemHover($link);
        }
    );

    function applyHoverStyles($item, $link) {
        if (!$item.data('originalBackground')) {
            $item.data('originalBackground', $item.css('backgroundColor'));
            $link.data('originalBackground', $link.css('backgroundColor'));
            $link.data('originalBorder', $link.css('borderBottomColor'));
        }
        $item.css('backgroundColor', '#2b2b2b');
        $link.css({'backgroundColor': '#2b2b2b', 'borderBottomColor': '#ffffff'});
        if ($item.hasClass('dropdown')) $item.find('.dropdown-link').css('borderBottomColor', '#ffffff');
    }

    function removeHoverStyles($item, $link) {
        $item.css('backgroundColor', $item.data('originalBackground'));
        $link.css({
            'backgroundColor': $link.data('originalBackground'),
            'borderBottomColor': $link.data('originalBorder')
        });
        if ($item.hasClass('dropdown')) $item.find('.dropdown-link').css('borderBottomColor', $link.data('originalBorder'));
    }

    function applyDropdownItemHover($link) {
        if (!$link.data('originalBackground')) {
            $link.data('originalBackground', $link.css('backgroundColor'));
            $link.data('originalPadding', $link.css('paddingLeft'));
        }
        $link.css({'backgroundColor': '#2b2b2b', 'paddingLeft': '20px'});
    }

    function removeDropdownItemHover($link) {
        $link.css({'backgroundColor': $link.data('originalBackground'), 'paddingLeft': $link.data('originalPadding')});
    }
}