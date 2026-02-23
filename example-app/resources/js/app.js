import './bootstrap';
import $ from 'jquery';

window.$ = window.jQuery = $;


import('./history-tracker/history-tracker-init.js');
import('./footer/dateTime.js');
import('./navigation/navigation-init.js');
import('./gallery/gallery-init.js');
import('./popover.js');
import('./modal/modal-init.js');
import('./calendar/init-calendar.js');

import { initContactForm } from './contactForm-vue.js';
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('contactApp')) {
        initContactForm();
    }
});
