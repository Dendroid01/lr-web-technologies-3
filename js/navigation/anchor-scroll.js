export function initAnchorScroll() {
    $('a[href^="#"]').on('click', function (e) {
        if (this.hash !== "") {
            e.preventDefault();
            const hash = this.hash;
            const $target = $(hash);

            if ($target.length) {
                $('html, body').animate({scrollTop: $target.offset().top - 80}, 800, 'swing');
                if (history.pushState) history.pushState(null, null, hash);
                else location.hash = hash;
            }
        }
    });
}