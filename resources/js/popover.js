$(function () {
    const $popover = $('<div class="form-popover"></div>')
        .hide()
        .appendTo('body');

    let hideTimeout = null;

    const config = {
        delay: 500,
        offset: 10
    };

    function initPopovers() {
        addFieldPopovers();
        bindFormEvents();
    }

    function addFieldPopovers() {
        const fields = {
            '#fullname': 'ФИО должно содержать три слова (например: Иванов Иван Иванович)',
            '#email': 'Введите корректный e-mail адрес (example@mail.com)',
            '#phone': 'Телефон должен начинаться с +7, +3 и содержать 9–12 цифр',
            '#birthdate': 'Формат даты: месяц/день/год (MM/DD/YYYY)',
            '#message': 'Введите текст сообщения',
            '.gender-options': 'Выберите ваш пол',
            '#age': 'Выберите вашу возрастную категорию',
            '.test-form input[name="fullname"]': 'ФИО должно содержать три слова',
            '.test-form input[name="q1"]': 'Ответьте на вопрос по физике',
            '.test-form input[name="q2"]': 'Выберите ровно два варианта ответа',
            '.test-form select[name="q3"]': 'Выберите правильный ответ'
        };

        $.each(fields, function (selector, text) {
            $(selector).attr('data-popover', text);
        });
    }

    function bindFormEvents() {
        $(document)
            .on('mouseenter focusin', '[data-popover]', function (e) {
                showPopover($(e.currentTarget));
            })
            .on('mouseleave focusout', '[data-popover]', function () {
                scheduleHide();
            });

        $(window).on('scroll resize', hidePopover);
    }

    function showPopover($target) {
        const text = $target.data('popover');
        if (!text) return;

        clearTimeout(hideTimeout);

        $popover.stop(true, true)
            .text(text)
            .fadeIn(150);

        positionPopover($target);
    }

    function positionPopover($target) {
        const targetOffset = $target.offset();
        const targetWidth = $target.outerWidth();
        const popoverWidth = $popover.outerWidth();
        const popoverHeight = $popover.outerHeight();

        // Располагаем всегда СВЕРХУ
        const top = targetOffset.top - popoverHeight - config.offset;
        const left = targetOffset.left + (targetWidth / 2) - (popoverWidth / 2);

        // Не вылезаем за границы экрана
        const safeTop = Math.max(10, top);
        const safeLeft = Math.max(10, Math.min($(window).width() - popoverWidth - 10, left));

        $popover.css({
            position: 'absolute',
            top: safeTop,
            left: safeLeft,
            zIndex: 9999
        });
    }

    function scheduleHide() {
        clearTimeout(hideTimeout);
        hideTimeout = setTimeout(hidePopover, config.delay);
    }

    function hidePopover() {
        $popover.stop(true, true).fadeOut(200);
    }

    initPopovers();
});
