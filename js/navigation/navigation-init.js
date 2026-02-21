import {initActiveLink} from './active-link.js';
import {initDropdownHover} from './dropdown-hover.js';
import {initAnchorScroll} from './anchor-scroll.js';
import {initLoadingIndicator} from './loading-indicator.js';

$(document).ready(function () {
    initActiveLink();
    initDropdownHover();
    initAnchorScroll();
    initLoadingIndicator();
});