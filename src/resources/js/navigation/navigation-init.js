import { initSidebarDropdown } from './sidebar-dropdown.js';
import {initActiveLink} from './active-link.js';
import {initAnchorScroll} from './anchor-scroll.js';
import {initLoadingIndicator} from './loading-indicator.js';

$(document).ready(function () {
    initActiveLink();
    initSidebarDropdown();
    initAnchorScroll();
    initLoadingIndicator();
});
