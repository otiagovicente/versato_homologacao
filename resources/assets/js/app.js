
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component(
    'regions-form',
    require('./components/regions/RegionsForm.vue')
);
Vue.component(
    'macroregions-form',
    require('./components/macroregions/MacroRegionsForm.vue')
);
Vue.component(
    'page-header-form',
    require('./components/general/page-header.vue')
);
Vue.component(
    'create-product',
    require('./components/products/CreateProducts.vue')
);
Vue.component(
    'edit-product',
    require('./components/products/EditProducts.vue')
);
Vue.component(
    'line-form',
    require('./components/lines/LineForm.vue')
);
Vue.component(
    'user-form',
    require('./components/users/UserForm.vue')
);
Vue.component(
    'profile-edit-form',
    require('./components/users/ProfileEditForm.vue')
);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: 'body'
});