import {showModal} from './core.js';

const triggersConfig = [
    {
        selector: '.university-info',
        position: 'after',
        modalType: 'education-details',
        buttonText: 'Подробнее об университете',
        buttonClass: 'modal-trigger'
    },
    {
        selector: '.study-plan',
        position: 'before',
        modalType: 'study-plan-help',
        buttonText: 'Помощь по чтению плана',
        buttonClass: 'modal-trigger'
    },
    {
        selector: '.contact-form',
        position: 'before',
        modalType: 'contact-help',
        buttonText: 'Помощь по заполнению формы',
        buttonClass: 'modal-trigger'
    },
    {
        selector: '#gallery',
        position: 'before',
        modalType: 'gallery-help',
        buttonText: 'Как пользоваться галереей',
        buttonClass: 'modal-trigger'
    }
];

let isListenerBound = false;

function addButtonIfNotExists($target, config) {
    const buttonSelector = `.${config.buttonClass}[data-modal="${config.modalType}"]`;

    if ($target.siblings(buttonSelector).length === 0) {
        const $button = $(`<button class="${config.buttonClass}" data-modal="${config.modalType}">${config.buttonText}</button>`);

        switch(config.position) {
            case 'before':
                $target.before($button);
                break;
            case 'after':
                $target.after($button);
                break;
            case 'prepend':
                $target.prepend($button);
                break;
            case 'append':
                $target.append($button);
                break;
        }
    }
}

function bindModalTriggerListener() {
    if (isListenerBound) return;

    $(document).on('click', '.modal-trigger', (e) => {
        const $btn = $(e.currentTarget);
        const type = $btn.data('modal');

        if (type) {
            showModal(type);
        }
    });

    isListenerBound = true;
}

function addModalTriggers() {
    // Страница гостевой книги — пропускаем
    if (window.location.pathname.includes('guest-book')) {
        return;
    }

    triggersConfig.forEach(config => {
        const $elements = $(config.selector);

        if ($elements.length) {
            $elements.each((index, element) => {
                addButtonIfNotExists($(element), config);
            });
        }
    });
}

function observeDynamicContent() {
    const observer = new MutationObserver((mutations) => {
        let shouldUpdate = false;

        mutations.forEach((mutation) => {
            if (mutation.addedNodes.length) {
                shouldUpdate = true;
            }
        });

        if (shouldUpdate) {
            addModalTriggers();
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}

function initTriggers() {
    bindModalTriggerListener();
    addModalTriggers();
    observeDynamicContent();
}

export {addModalTriggers, initTriggers, bindModalTriggerListener};
