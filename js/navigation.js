$(document).ready(function () {

    $('.dropdown').hover(
        function () {
            $(this).find('.dropdown-menu').addClass('active');
        },
        function () {
            $(this).find('.dropdown-menu').removeClass('active');
        }
    );

    const currentPage = window.location.pathname.split('/').pop() || 'index.html';

    $('header nav a').each(function () {
        const linkPage = $(this).attr('href').split('#')[0];
        if (linkPage === currentPage) {
            $(this).addClass('active');

            if ($(this).hasClass('dropdown-link')) {
                $(this).closest('.dropdown').find('.dropdown-link').addClass('active');
            }
        }
    });

    $('header nav > ul > li').hover(
        function () {
            const $item = $(this);
            const $link = $item.find('a').first();

            if (!$link.hasClass('active')) {
                applyHoverStyles($item, $link);
            }
        },
        function () {
            const $item = $(this);
            const $link = $item.find('a').first();

            if (!$link.hasClass('active')) {
                removeHoverStyles($item, $link);
            }
        }
    );

    function applyHoverStyles($item, $link) {
        if (!$item.data('originalBackground')) {
            $item.data('originalBackground', $item.css('backgroundColor'));
            $link.data('originalBackground', $link.css('backgroundColor'));
            $link.data('originalBorder', $link.css('borderBottomColor'));
        }

        $item.css('backgroundColor', '#2b2b2b');
        $link.css({
            'backgroundColor': '#2b2b2b',
            'borderBottomColor': '#ffffff'
        });

        if ($item.hasClass('dropdown')) {
            $item.find('.dropdown-link').css('borderBottomColor', '#ffffff');
        }
    }

    function removeHoverStyles($item, $link) {
        $item.css('backgroundColor', $item.data('originalBackground'));
        $link.css({
            'backgroundColor': $link.data('originalBackground'),
            'borderBottomColor': $link.data('originalBorder')
        });

        if ($item.hasClass('dropdown')) {
            $item.find('.dropdown-link').css('borderBottomColor', $link.data('originalBorder'));
        }
    }

    $('.dropdown-menu a').hover(
        function () {
            const $link = $(this);
            if (!$link.hasClass('active')) {
                applyDropdownItemHover($link);
            }
        },
        function () {
            const $link = $(this);
            if (!$link.hasClass('active')) {
                removeDropdownItemHover($link);
            }
        }
    );

    function applyDropdownItemHover($link) {
        if (!$link.data('originalBackground')) {
            $link.data('originalBackground', $link.css('backgroundColor'));
            $link.data('originalPadding', $link.css('paddingLeft'));
        }

        $link.css({
            'backgroundColor': '#2b2b2b',
            'paddingLeft': '20px'
        });
    }

    function removeDropdownItemHover($link) {
        $link.css({
            'backgroundColor': $link.data('originalBackground'),
            'paddingLeft': $link.data('originalPadding')
        });
    }

    $('a[href^="#"]').on('click', function (e) {
        if (this.hash !== "") {
            e.preventDefault();

            const hash = this.hash;
            const $target = $(hash);

            if ($target.length) {
                $('html, body').animate({
                    scrollTop: $target.offset().top - 80
                }, 800, 'swing');

                if (history.pushState) {
                    history.pushState(null, null, hash);
                } else {
                    location.hash = hash;
                }
            }
        }
    });

    $('a').on('click', function () {
        const href = $(this).attr('href');

        if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !href.startsWith('mailto:')) {
            showLoadingIndicator();
        }
    });

    function showLoadingIndicator() {
        const $indicator = $('<div class="page-loading-indicator"></div>')
            .css({
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'width': '100%',
                'height': '3px',
                'background': 'linear-gradient(90deg, var(--color-accent), #004494)',
                'z-index': '9999',
                'animation': 'loadingProgress 1.5s infinite'
            })
            .appendTo('body');

        setTimeout(function () {
            $indicator.remove();
        }, 3000);
    }

    if (!$('#navigation-styles').length) {
        $('<style id="navigation-styles">')
            .text(`
                @keyframes loadingProgress {
                    0% { transform: translateX(-100%); }
                    50% { transform: translateX(0%); }
                    100% { transform: translateX(100%); }
                }
            `)
            .appendTo('head');
    }
});