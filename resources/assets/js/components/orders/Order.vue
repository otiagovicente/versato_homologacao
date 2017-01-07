<template>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="/">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="/orders">Pedidos</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="{{getUrl()}}">Pedido</a>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <button class="btn green-jungle pull-right" style="margin-right:10px;" v-on:click="save()">Guardar Pedido</button>
                   <a href="/products"><button class="btn blue pull-right" style="margin-right:10px;">Adicionar Producto</button></a>
                    <div class="form-group">
                        <label for="sel1">Status:</label>
                        <select class="form-control" id="sel1" v-model="order.status_id">
                            <option value="1">Abierto</option>
                            <option value="2">Aprovado</option>
                            <option value="3">Reprovado</option>
                            <option value="4">Faturado</option>
                            <option value="5">Enviado</option>
                            <option value="6">Recebido</option>
                        </select>
                    </div>
                </div>
            </div>

            <br>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">Pedido</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-3 col-sm-3 col-xs-3 block-center">
                                <h2 v-show="customer.id" class="font-blue" style="cursor:pointer;" v-on:click="addCustomer()" >{{customer.name}}</h2>
                                <small v-show="customer.id">{{customer.company}} - cuit: {{customer.cuit}}</small>
                                <button v-show="!customer.id" class="btn blue" v-on:click="addCustomer()">Agregar Cliente</button>


                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <h3>Descuento:</h3>
                                <slider-component :slider_width="180" :slider_max="10" :slider_value.sync="order.customer_discount"></slider-component>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <h3>Descuento Rep.:</h3>
                                <slider-component :slider_width="180" :slider_max="5" :slider_value.sync="order.representative_discount"></slider-component>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
                                <h3 class="font-blue">Total <strong>{{order.total | currency '$ '}}</strong></h3>
                                <h4 class="font-blue"><s> {{order.price | currency '$ '}}</s></h4>
                                <hr>
                                <h2 v-show="representative.id" class="font-blue" v-on:click="addRepresentative()" style="cursor:pointer;">{{representative.user.name+' '+representative.user.lastname}}</h2>
                                <small v-show="representative.id">{{representative.user.email}} - code: {{representative.code}}</small>
                                <button v-show="!representative.id" class="btn blue" v-on:click="addRepresentative()">Agregar Representante</button>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" v-model="order.comment" placeholder="Comentarios" style="width:100%;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject bold uppercase">Productos</span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-2 col-sm-2 col-xs-2"></div>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <h4>Cantidad</h4>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <h4>Descuento</h4>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <h4>Descuento Rep.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="portlet-body">
                            <div class="product-list-list" v-if="!products.product">
                                <div  class="col-md-12 col-sm-12 col-xs-12" v-for="product in products">

                                    <div class="col-md-12 col-sm-12 col-xs-12 product-list-product-box">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <img v-show="product.product.photo" v-bind:src="product.product.photo" class="product-list-photo">
                                        </div>
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div class="input-group">
                                                        <slider-component :slider_value.sync="product.amount" v-on:update="setProductAmount(product.product.id)" :slider_max="250"></slider-component>
                                                        <!--<input class="form-control" type="number" min="0" v-model="product.amount" aria-label="Cantidad">-->
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <slider-component :slider_value.sync="product.discount"  v-on:update="setProductCustomerDiscount(product.product.id)" :slider_max="10" slider_fgcolor="#8bed8c"></slider-component>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <slider-component :slider_value.sync="product.representative_discount" v-on:update="setProductRepresentativeDiscount(product.product.id)" :slider_max="5" slider_fgcolor="#8bed8c"></slider-component>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <h4 class="font-blue">Tarea <strong>{{ product.total | currency '$' }}</strong></h4>
                                                    <h5 class="font-blue"><s>{{product.total_sum | currency '$'}}</s></h5>
                                                    <h5 class="font-blue" v-show="product.product.price">{{product.product.price | currency '$' }} un</h5>
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
    <order-add-representative></order-add-representative>
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
    import OrderAddRepresentative from './OrderAddRepresentative.vue';
    export default{

        components: {
            'slider-component': Slider,
            'order-add-customer': OrderAddCustomer,
            'order-add-representative': OrderAddRepresentative
        },
        data(){
            return {
                customer: {
                    cuit: '',
                    name: '',
                    company: ''
                },
                representative: {
                    code: '',
                    user: {
                        name: '',
                        lastname: '',
                        email: ''
                    }
                },
                products: {
                    product: {
                        total: 0,
                        total_sum: 0,
                        total_customer_discount: 0,
                        total_representative_discount: 0,
                        total_discount: 0,
                        price: 0.00,
                        photo: '',
                    }
                },
                order: {
                    comment: '',
                    status_id: 1,
                    representative_discount: 0.00,
                    customer_discount: 0.00
                }
            }
        },
        watch: {
            'order.customer_id': function (val) {
                if (val) {
                    _Order.getCustomer();
                }
            },
            'order.representative_id': function (val) {
                if (val) {
                    _Order.getRepresentative();
                }
            },
            'order.comment': function (val) {
                _Order.setComment();
            },
            'order.customer_discount': function (val, oldVal) {
                if (val) {
                    _Order.setCustomerDiscount();
                }
            },
            'order.status_id': function (val, oldVal) {
                if (val != oldVal) {
                    _Order.setStatus();
                }
            },
            'order.representative_discount': function (val, oldVal) {
                if (val != oldVal) {
                    _Order.setRepresentativeDiscount();
                }
            },
            'products': function (val, oldVal) {
                if (val != oldVal) {
                    _Order.getOrder();
                }
            }

        },
        computed: {},
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
            getUrl(){
                return window.location.pathname;
            },
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
            calculateProductValue(product_id){
                this.$http.get('/shopping-cart/calculate-product/' + product_id)
                        .then(response => {

                        }).catch(response => {

                });
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
            getRepresentative(){
                this.$http.post('/shopping-cart/get-representative')
                        .then(response => {
                            _Order.representative = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fué possible cargar el Representante');
                        });
            },
            addRepresentative(){
                _OrderAddRepresentative.openWindow();
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
            setComment(){
                this.$http.post('/shopping-cart/set-comment', _Order.order)
                        .then(response => {
                            console.log('Comments saved');
                        })
                        .catch(response => {
                            console.log("Comments didn't save");
                        });
            },
            setCustomerDiscount(){
                this.$http.post('/shopping-cart/set-customer-discount/', _Order.order)
                        .then(response => {
                            _Order.order.customer_discount = response.json();
                            _Order.getProducts();
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
                            _Order.getProducts();
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
                            _Order.getProducts();
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
                            _Order.getProducts();
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
                            _Order.getProducts();
                        })
                        .catch(response => {
                            toastr.error('No se aplicó el descuento');
                        });
            },
            setStatus(){
                this.$http.post('/shopping-cart/set-status', _Order.order)
                        .then(response => {
                            _Order.order.status_id = response.json();
                        }).catch(response => {
                    toastr.error('No fué posible atualizar el status del pedido');
                });
            },
            getStatus(){
            },

            save(){
                alert('ué');
                this.$http.post('/shopping-cart/save', _Order.order)
                        .then(response => {
                            toastr.success('Pedido guardado');
                            _Order.getOrder();
                        })
                        .catch(response => {
                            toastr.error('no fué posible cargar el pedido');
                            _Order.showErrors(response.json());
                        });


            },
            showErrors: function (data) {
                $.each(data, function (key, value) {
                    toastr.warning('Atención', value);
                    $('#' + key).addClass('has-error');
                });
            },

        }

    }
</script>
