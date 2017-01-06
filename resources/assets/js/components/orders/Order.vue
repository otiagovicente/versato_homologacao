<template>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">Pedido</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3 block-center">
                                <h2 v-show="customer" class="font-blue">{{customer.name}}</h2>
                                <small v-show="customer">{{customer.company}} - cuit: {{customer.cuit}}</small>
                                <button v-show="!customer" class="btn blue" v-on:click="addCustomer()">Agregar Cliente</button>


                            </div>
                            <div class="col-md-3">
                                <h3>Descuento:</h3>
                                <slider-component :slider_width="180" :slider_max="10" :slider_value.sync="order.customer_discount"></slider-component>
                            </div>

                            <div class="col-md-3">
                                <h3>Descuento Rep.:</h3>
                                <slider-component :slider_width="180" :slider_max="5" :slider_value.sync="order.representative_discount"></slider-component>
                            </div>
                            <div class="col-md-3">
                                <h3 class="font-blue">Total <strong>{{order.total | currency '$ '}}</strong></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject bold uppercase">Productos</span>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <h4>Cantidad</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>Descuento</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>Descuento Rep.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="portlet-body">
                            <div class="product-list-list">
                                <div class="col-md-12" v-for="product in products">

                                    <div class="col-md-12 product-list-product-box">
                                        <div class="col-md-2">
                                            <img v-bind:src="product.product.photo" class="product-list-photo">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="col-md-12">
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <slider-component :slider_value.sync="product.amount" v-on:update="setProductAmount(product.product.id)" :slider_max="250"></slider-component>
                                                        <!--<input class="form-control" type="number" min="0" v-model="product.amount" aria-label="Cantidad">-->
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <slider-component :slider_value.sync="product.discount"  v-on:update="setProductCustomerDiscount(product.product.id)" :slider_max="10" slider_fgcolor="#8bed8c"></slider-component>
                                                </div>
                                                <div class="col-md-3">
                                                    <slider-component :slider_value.sync="product.representative_discount" v-on:update="setProductRepresentativeDiscount(product.product.id)" :slider_max="5" slider_fgcolor="#8bed8c"></slider-component>
                                                </div>
                                                <div class="col-md-3">
                                                    <h4 class="font-blue">Tarea <strong>{{ product.total | currency '$' }}</strong></h4>
                                                    <h5 class="font-blue">{{product.total_sum }}</h5>
                                                    <h5 class="font-blue">{{product.product.price | currency '$' }} un</h5>
                                                </div>


                                            </div>
                                        </div>
                                        <i class="fa fa-close delete-product" v-on:click="deleteProduct(product.product.id)"></i>
                                    </div>
                                </div>

                            </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <order-add-customer></order-add-customer>
</template>
<style scoped>
    body{
        background-color:#ff0000;
    }
    .product-list-list{
        height: 800px;
        overflow: scroll;
    }
    .product-list-product-box{
        background-color: #FFFFFF;
        margin-bottom:5px;
        padding-top: 5px;
        padding-bottom: 5px;
        position: relative;
    }
    .product-list-product-box:hover{
        background-color: #FEFEFF;
    }
    .product-list-product-box .delete-product{
        color: #eaeaea;
        position: absolute;
        right : 10px;
        top: 10px;
        cursor: pointer;
    }
    .product-list-product-box:hover .delete-product{
        color: #ee0000;
        cursor: pointer;
    }
    .product-list-photo{
        width:150px;
        height:auto;
    }
</style>
<script type="text/babel">
    import Slider from '../general/sliders/Slider.vue';
    import OrderAddCustomer from './OrderAddCustomer.vue';
    export default{

        components: {
            'slider-component': Slider,
            'order-add-customer': OrderAddCustomer,
        },
        data(){
            return {
                customer: null,
                products: {
                    product: {
                        total: 0,
                        total_sum: 0,
                        total_customer_discount : 0,
                        total_representative_discount : 0,
                        total_discount : 0,
                        price : 0.00,
                        photo : '',
                     }
                },
                order: {
                }
        }
        },
        watch: {
            'order.customer_id': function (val) {
                if (val) {
                    _Order.getCustomer();
                }
            },
            'order.customer_discount': function (val, oldVal) {
                _Order.setCustomerDiscount();
            },
            'order.representative_discount': function (val, oldVal) {
                _Order.setRepresentativeDiscount();
            },
            'products' : function(val){
                _Order.calculateTotal();
            }

        },
        computed: {

        },
        events: {
            'load-order': function () {
                console.log('loading-order');
                this.getOrder();
            }
        },
        ready(){
            window._Order = this;
            _Order.getProducts();
            _Order.getOrder();
        },
        methods: {
            getProducts(){
                this.$http.get('/shopping-cart/get-products')
                        .then(response => {
                            _Order.products = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fué possible cargar los productos');
                        });
            },
            getOrder(){
                this.$http.get('/shopping-cart/get-order')
                        .then(response => {
                            _Order.order = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fué posible cargar el pedido');
                        });
            },

            calculateTotal(){
                var total = 0.00;

                if(this.$data.products.length > 1){
                    _.each(this.$data.products, function (product, key) {

                        product.total_sum = ((product.product.price * product.grid.total) * product.amount);
                        product.total_customer_discount = (product.total_sum * (_Order.order.customer_discount / 100));
                        product.total_representative_discount = (product.total_sum * (_Order.order.representative_discount / 100));

                        if (product.discount) {
                            product.total_customer_discount = Number((product.total_sum * (product.discount / 100)), 2);
                        }
                        if (product.representative_discount) {
                            product.total_representative_discount = Number((product.total_sum * (product.representative_discount / 100)), 2);
                        }

                        product.total_discount =  Number((product.total_customer_discount + product.total_representative_discount), 2);

                        product.total = Number((product.total_sum - product.total_discount), 2);

                        total += Number(product.total, 2);
                    });
                }

                _Order.order.total = total;
            },
            deleteProduct(product_id){
                this.$http.get('/shopping-cart/delete-product/' + product_id)
                        .then(response => {
                            _Order.getProducts();
                        })
                        .catch(response => {
                            toastr.error('No fué posible eliminar el producto');
                        });
            },
            getCustomer(){
                this.$http.get('/shopping-cart/get-customer/')
                        .then(response => {
                            _Order.customer = response.json();
                        }).catch(response => {
                    toastr.error('No fué possible cargar el Cliente');
                });
            },
            addCustomer(){
                _OrderAddCustomer.openWindow();
            },
            setCustomerDiscount(){
                this.$http.post('/shopping-cart/set-customer-discount/', _Order.order)
                        .then(response => {
                            _Order.order.customer_discount = response.json();
                            console.log('Disconto atualizado');
                        })
                        .catch(response => {
                            console.log('Disconto não atualizado');
                        });
            },
            setRepresentativeDiscount(){
                this.$http.post('/shopping-cart/set-representative-discount/', _Order.order)
                        .then(response => {
                            _Order.order.representative_discount = response.json();
                            console.log('Disconto atualizado');
                        })
                        .catch(response => {
                            console.log('Disconto não atualizado');
                        });
            },
            setProductAmount(product_id){
                var product = _.find(_Order.products, function (obj) {
                    return obj.product.id === product_id;
                });
                this.$http.post('/shopping-cart/set-product-amount', product)
                        .then(response => {
                            product.product.amount = response.json();
                        })
                        .catch(response => {
                            toastr.error('No se aplicó el descuento');
                        });
            },
            setProductCustomerDiscount(product_id){
                var product = _.find(_Order.products, function (obj) {
                    return obj.product.id === product_id;
                });
                this.$http.post('/shopping-cart/set-product-customer-discount', product)
                        .then(response => {
                            product.product.discount = response.json();
                        })
                        .catch(response => {
                            toastr.error('No se aplicó el descuento');
                        });
            },
            setProductRepresentativeDiscount(product_id){
                var product = _.find(_Order.products, function (obj) {
                    return obj.product.id === product_id;
                });
                this.$http.post('/shopping-cart/set-product-representative-discount', product)
                        .then(response => {
                            product.product.representative_discount = response.json();
                        })
                        .catch(response => {
                            toastr.error('No se aplicó el descuento');
                        });
            },

        }

    }
</script>
