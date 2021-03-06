window._ = require('lodash');

window.moment = require('moment');
require('moment/locale/es');
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
require('bootstrap-switch');
window.cookie = require('js-cookie');
require('jquery-slimscroll');

window.toastr = require('toastr');

window.algoliasearch = require('algoliasearch');
window.autocomplete = require('autocomplete.js');
window.jQueryKnob = require('jquery-knob');

window.jQueryBridget = require('jquery-bridget');
window.Masonry = require('masonry-layout');
window.imagesLoaded = require('imagesloaded');

// make Masonry a jQuery plugin
jQueryBridget( 'masonry', Masonry, $);
imagesLoaded.makeJQueryPlugin($);

window.bootbox = require('bootbox');

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo"

/*window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '6c3dd34a782803571d89'
});*/



/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue/dist/vue.js');
window.VueResource = require('vue-resource');
window.EventBus = new Vue({});

Object.defineProperties(Vue.prototype, {
    $bus: {
        get: function () {
            return window.EventBus;
        }
    }
});

Vue.use(VueResource);

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
    next();
});


/*Vue.http.interceptors.push((request, next)  => {
    next((response) => {
        response.data = JSON.parse(response.data);
    });
});
*/

