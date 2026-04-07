export function initLoadingIndicator() {
    $('a').on('click', function () {
        const href = $(this).attr('href');
        if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !href.startsWith('mailto:')) {
            showLoadingIndicator();
        }
    });

    function showLoadingIndicator() {
        const $indicator = $('<div class="page-loading-indicator"></div>').css({
            'position': 'fixed',
            'top': '0',
            'left': '0',
            'width': '100%',
            'height': '3px',
            'background': 'linear-gradient(90deg, var(--color-accent), #004494)',
            'z-index': '9999',
            'animation': 'loadingProgress 1.5s infinite'
        }).appendTo('body');

        setTimeout(() => $indicator.remove(), 3000);
    }

    if (!$('#navigation-styles').length) {
        $('<style id="navigation-styles">').text(`
            @keyframes loadingProgress {
                0% { transform: translateX(-100%); }
                50% { transform: translateX(0%); }
                100% { transform: translateX(100%); }
            }
        `).appendTo('head');
    }
}