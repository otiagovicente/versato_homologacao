
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




/*
 * Componentes de Brands
 */

    Vue.component(
        'create-brand',
        require('./components/brands/CreateBrand.vue')
    );




/*
 * Componente Header de páginas
 */

    Vue.component(
        'page-header-form',
        require('./components/general/page-header.vue')
    );



/*
 *  Componentes de DeliveryCenters
 */

    Vue.component(
        'create-deliverycenter',
        require('./components/deliverycenters/CreateDeliverycenter.vue')
    );
    Vue.component(
        'edit-deliverycenter',
        require('./components/deliverycenters/EditDeliverycenter.vue')
    );
    Vue.component(
        'show-deliverycenter',
        require('./components/deliverycenters/ShowDeliverycenter.vue')
    );
    Vue.component(
        'list-deliverycenter',
        require('./components/deliverycenters/ListDeliverycenter.vue')
    );

/*
 *  Componentes de Clientes
 */

    Vue.component(
        'create-customer',
        require('./components/customers/CreateCustomer.vue')
    );
    Vue.component(
        'edit-customer',
        require('./components/customers/EditCustomer.vue')
    );
    Vue.component(
        'show-customer',
        require('./components/customers/ShowCustomer.vue')
    );
    Vue.component(
        'list-customers',
        require('./components/customers/ListCustomers.vue')
    );




/*
 *  Componentes de Representantes
 */

    Vue.component(
        'list-representatives',
        require('./components/representatives/ListRepresentatives.vue')
    );
    Vue.component(
        'create-representative',
        require('./components/representatives/CreateRepresentative.vue')
    );
    Vue.component(
        'edit-representative',
        require('./components/representatives/EditRepresentative.vue')
    );
    Vue.component(
        'select-user',
        require('./components/representatives/SelectUser.vue')
    );
    Vue.component(
        'select-region',
        require('./components/representatives/SelectRegion.vue')
    );
    Vue.component(
        'select-brands',
        require('./components/representatives/SelectBrands.vue')
    );






/*
 *  Componentes de Produto
 */
    Vue.component(
        'create-product',
        require('./components/products/CreateProducts.vue')
    );

    Vue.component(
        'list-products',
        require('./components/products/ListProducts.vue')
    );


/*
 *   Componentes de Linha
 */
    Vue.component(
        'line-form',
        require('./components/lines/LineForm.vue')
    );




/*
 *  Componentes de Cores
 */

    Vue.component(
        'colors-list',
        require('./components/colors/ColorsList.vue')
    );





/*
 *   Componentes de Usuário
 */


    Vue.component(
        'user-profile',
        require('./components/users/UserProfile.vue')
    );
    Vue.component(
        'user-form',
        require('./components/users/UserForm.vue')
    );
    Vue.component(
        'profile-edit-form',
        require('./components/users/ProfileEditForm.vue')
    );




/*
 * Componentes Passport - Autenticação JWT
 */
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




/*
 * Componentes de Macro Regiões
 */

Vue.component(
    'regions-form',
    require('./components/regions/regionsForm.vue')
);
Vue.component(
    'macroregions-form',
    require('./components/macroregions/MacroRegionsForm.vue')
);

/*
* Componentes de Shops
*/

Vue.component(
    'shop-form',
    require('./components/shops/shopForm.vue')
);

Vue.component(
    'list-shops',
    require('./components/shops/ListShops.vue')
);

/*
* Componentes de Pedidos
*/

Vue.component(
    'order-form',
    require('./components/orders/OrderForm.vue')
);

// Vue.component(
//     'order-report-by-customer',
//     require('./components/orders/ReportOrdersByCustomer.vue')
// );

window.app = new Vue({
    el: 'body',
    methods: {
        initMap: function(){
            this.$broadcast('MapsApiLoaded');
        }
    }

});