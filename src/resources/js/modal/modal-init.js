import {initModal} from './core.js';
import {addModalTriggers, initTriggers, bindModalTriggerListener} from './triggers.js';

$(document).ready(function () {
    initModal();
    addModalTriggers();
    initTriggers();
});
