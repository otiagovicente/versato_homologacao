
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');
require('materialize-css');

window.toastr = require('toastr');
window.algoliasearch = require('algoliasearch');
window.autocomplete = require('autocomplete.js');
window.jQueryKnob = require('jquery-knob');

window.jQueryBridget = require('jquery-bridget');
require('daterangepicker');
window.Masonry = require('masonry-layout');
window.imagesLoaded = require('imagesloaded');

// make Masonry a jQuery plugin
jQueryBridget('masonry', Masonry, $);
imagesLoaded.makeJQueryPlugin($);

window.bootbox = require('bootbox');
/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo"

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '6c3dd34a782803571d89'
});

require('./MagnaLibrary');