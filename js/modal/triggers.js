import {showModal} from './core.js';

function addModalTriggers() {
    if ($('.university-info').length) {
        $('.university-info').after('<button class="modal-trigger" data-modal="education-details">Подробнее об университете</button>');
    }
    if ($('.study-plan').length) {
        $('.study-plan').before('<button class="modal-trigger" data-modal="study-plan-help">Помощь по чтению плана</button>');
    }
    if ($('.contact-form').length) {
        $('.contact-form').before('<button class="modal-trigger" data-modal="contact-help">Помощь по заполнению формы</button>');
    }
    if ($('#gallery').length) {
        $('#gallery').before('<button class="modal-trigger" data-modal="gallery-help">Как пользоваться галереей</button>');
    }

    $(document).on('click', '.modal-trigger', (e) => {
        const type = $(e.currentTarget).data('modal');
        showModal(type);
    });
}

export {addModalTriggers};