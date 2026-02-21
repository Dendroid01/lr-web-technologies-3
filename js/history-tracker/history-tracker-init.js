import {HistoryStorage} from './HistoryStorage.js';
import {HistoryUI} from './HistoryUI.js';

$(document).ready(function () {
    HistoryStorage.init();
    HistoryUI.init();
});