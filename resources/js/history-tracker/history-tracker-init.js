import {HistoryTracker} from './tracker.js';
import {HistoryUI} from './HistoryUI.js'

$(document).ready(function () {
    const currentPage = HistoryTracker.getCurrentPage();
    HistoryTracker.trackPageVisit(currentPage);

    HistoryUI.init();
});