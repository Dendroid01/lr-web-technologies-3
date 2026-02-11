$(document).ready(function() {
    const $modal = $('<div class="blur-modal"></div>');
    let modalContent = '';

    function initModal() {
        createModalElement();
        bindEvents();
        addModalTriggers();
    }

    function createModalElement() {
        modalContent = `
            <div class="blur-modal-content">
                <span class="blur-modal-close">&times;</span>
                <div class="blur-modal-body"></div>
            </div>
        `;
        
        $modal.html(modalContent).hide().appendTo('body');
    }

    function bindEvents() {
        $modal.on('click', '.blur-modal-close', function() {
            hideModal();
        });
        
        $modal.on('click', function(e) {
            if (e.target === this) {
                hideModal();
            }
        });
        
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $modal.is(':visible')) {
                hideModal();
            }
        });
    }

    function addModalTriggers() {
        if ($('.university-info').length) {
            $('.university-info').after(
                '<button class="modal-trigger" data-modal="education-details">Подробнее об университете</button>'
            );
        }
        
        if ($('.study-plan').length) {
            $('.study-plan').before(
                '<button class="modal-trigger" data-modal="study-plan-help">Помощь по чтению плана</button>'
            );
        }
        
        if ($('.contact-form').length) {
            $('.contact-form').before(
                '<button class="modal-trigger" data-modal="contact-help">Помощь по заполнению формы</button>'
            );
        }
        
        if ($('#gallery').length) {
            $('#gallery').before(
                '<button class="modal-trigger" data-modal="gallery-help">Как пользоваться галереей</button>'
            );
        }
        
        $(document).on('click', '.modal-trigger', function(e) {
            const modalType = $(e.target).data('modal');
            showModalContent(modalType);
            showModal();
        });
    }

    function showModalContent(type) {
        const content = getModalContent(type);
        $modal.find('.blur-modal-body').html(content);
    }

    function getModalContent(type) {
        const contents = {
            'education-details': `
                <h2>Севастопольский государственный университет</h2>
                <p>Федеральное государственное автономное образовательное учреждение высшего образования "Севастопольский государственный университет" - один из ведущих вузов Крыма.</p>
                <p><strong>Основан:</strong> 2014 год</p>
                <p><strong>Местоположение:</strong> Севастополь, Республика Крым</p>
                <p><strong>Факультеты:</strong> Информационных технологий и управления, Технический, Экономики и управления и другие.</p>
                <p><strong>Кафедра информационных систем:</strong> Готовит специалистов в области разработки программного обеспечения, баз данных и информационной безопасности.</p>
                <p>Университет предлагает современные образовательные программы и имеет развитую инфраструктуру.</p>
            `,
            'study-plan-help': `
                <h2>Как читать план учебного процесса</h2>
                <div class="help-content">
                    <p><strong>Аббревиатуры в таблице:</strong></p>
                    <ul>
                        <li><strong>Ауд</strong> - Аудиторные занятия (общее количество часов в аудитории)</li>
                        <li><strong>Лк</strong> - Лекционные часы</li>
                        <li><strong>Лб</strong> - Лабораторные работы</li>
                        <li><strong>Пр</strong> - Практические занятия</li>
                        <li><strong>СРС</strong> - Самостоятельная работа студента</li>
                    </ul>
                    <p><strong>Расшифровка кафедр:</strong></p>
                    <ul>
                        <li><strong>БЖ</strong> - Безопасность жизнедеятельности</li>
                        <li><strong>ВМ</strong> - Высшая математика</li>
                        <li><strong>НГиГ</strong> - Национальная история и география</li>
                        <li><strong>ИС</strong> - Информационные системы</li>
                        <li><strong>ПЭОП</strong> - Природообустройство и экология</li>
                    </ul>
                    <p>Общее количество часов по дисциплине распределяется между различными видами учебной деятельности.</p>
                </div>
            `,
            'contact-help': `
                <h2>Помощь по заполнению контактной формы</h2>
                <div class="help-content">
                    <p><strong>Рекомендации по заполнению:</strong></p>
                    <ul>
                        <li><strong>ФИО:</strong> Введите фамилию, имя и отчество полностью (например: Иванов Иван Иванович)</li>
                        <li><strong>E-mail:</strong> Должен содержать символ @ и домен (например: example@mail.com)</li>
                        <li><strong>Телефон:</strong> Начинается с +7 или +3, затем 9-12 цифр (например: +79161234567)</li>
                        <li><strong>Дата рождения:</strong> Выберите из календаря или введите в формате ММ/ДД/ГГГГ</li>
                        <li><strong>Сообщение:</strong> Опишите подробно причину обращения</li>
                    </ul>
                    <p>Все поля обязательны для заполнения. Форма будет отправлена на указанный email адрес.</p>
                </div>
            `,
            'gallery-help': `
                <h2>Как пользоваться фотоальбомом</h2>
                <div class="help-content">
                    <p><strong>Основные возможности галереи:</strong></p>
                    <ul>
                        <li><strong>Просмотр фото:</strong> Нажмите на любое изображение для просмотра в увеличенном режиме</li>
                        <li><strong>Навигация:</strong> Используйте стрелки ← → на клавиатуре или кнопки в модальном окне</li>
                        <li><strong>Закрытие:</strong> Нажмите ESC, крестик в правом верхнем углу или кликните вне изображения</li>
                        <li><strong>Информация:</strong> Наведите курсор на фото для просмотра дополнительной информации</li>
                    </ul>
                    <p>Галерея поддерживает "ленивую" загрузку изображений для оптимизации производительности.</p>
                </div>
            `
        };
        
        return contents[type] || '<p>Содержание не найдено</p>';
    }

    function showModal() {
        $('body').addClass('modal-open');
        $modal.fadeIn(300);
        
        $modal.find('.blur-modal-content').css({
            'transform': 'scale(0.9)',
            'opacity': '0'
        }).animate({
            'transform': 'scale(1)',
            'opacity': '1'
        }, 300);
    }

    function hideModal() {
        $('body').removeClass('modal-open');
        $modal.fadeOut(300);
    }

    initModal();
});