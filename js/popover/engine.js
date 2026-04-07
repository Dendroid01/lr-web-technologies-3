import {bindPopoverAttributes} from './definitions.js';

$(function () {
    const $popover = $('<div class="form-popover"></div>').hide().appendTo('body');
    let hideTimeout = null;

    const config = {delay: 500, offset: 10};

    function initPopovers() {
        bindPopoverAttributes();
        bindFormEvents();
    }

    function bindFormEvents() {
        $(document)
            .on('mouseenter focusin', '[data-popover]', e => showPopover($(e.currentTarget)))
            .on('mouseleave focusout', '[data-popover]', scheduleHide);

        $(window).on('scroll resize', hidePopover);
    }

    function showPopover($target) {
        const text = $target.data('popover');
        if (!text) return;

        clearTimeout(hideTimeout);
        $popover.stop(true, true).text(text).fadeIn(150);
        positionPopover($target);
    }

    function positionPopover($target) {
        const offset = $target.offset();
        const popWidth = $popover.outerWidth();
        const popHeight = $popover.outerHeight();

        let top = offset.top - popHeight - config.offset;
        let left = offset.left + $target.outerWidth() / 2 - popWidth / 2;

        top = Math.max(10, top);
        left = Math.max(10, Math.min($(window).width() - popWidth - 10, left));

        $popover.css({position: 'absolute', top, left, zIndex: 9999});
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