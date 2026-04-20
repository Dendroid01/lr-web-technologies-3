export function initActiveLink() {
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
}