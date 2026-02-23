import './bootstrap';

// Импортируйте jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

await import('./history-tracker/history-tracker-init.js');
await import('./footer/dateTime.js');
await import('./navigation/navigation-init.js');
await import('./gallery/gallery-init.js');
await import('./popover.js');
await import('./modal/modal-init.js');
