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
                   <button class="btn red" style="margin-right:10px;" v-on:click="cancelOrder()">Cancelar Pedido</button>
                </div>
            </div>
            <br>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-3">

                            <h1>Pedido</h1>

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right">
                                <select class="col-md-9 col-sm-9 col-xs-9 form-control"  v-model="order.status_id">
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
                                <slider-component :slider_width="180" :slider_max="10" :slider_value.sync="order.company_discount"></slider-component>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <h3>Descuento Rep.:</h3>

                                <slider-component :slider_width="180" :slider_max="5" :slider_value.sync="order.representative_discount"></slider-component>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
                                <h3 class="font-blue">Total <strong>{{order.total | currency '$ '}}</strong></h3>
                                <h4 class="font-blue"><s> {{order.total_without_discount | currency '$ '}}</s></h4>
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
                                <textarea class="form-control" rows="5" v-model="order.comment" debounce="500" placeholder="Comentarios" style="width:100%;"></textarea>
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
                            <div class="product-list-list" v-if="!order.products.pivot">
                                <div  class="col-md-12 col-sm-12 col-xs-12" v-for="product in order.products">

                                    <div class="col-md-12 col-sm-12 col-xs-12 product-list-product-box">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <img v-show="product.photo" v-bind:src="product.photo" class="product-list-photo">
                                        </div>
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div class="input-group">
                                                        <slider-component :slider_value.sync="product.pivot.products_amount" v-on:update="updateOrder()" :slider_max="250"></slider-component>
                                                        <!--<input class="form-control" type="number" min="0" v-model="product.amount" aria-label="Cantidad">-->
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <slider-component :slider_value.sync="product.pivot.company_discount"  v-on:update="updateOrder()" :slider_max="10" slider_fgcolor="#8bed8c"></slider-component>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <slider-component :slider_value.sync="product.pivot.representative_discount" v-on:update="updateOrder()" :slider_max="5" slider_fgcolor="#8bed8c"></slider-component>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <h4 class="font-blue">Tarea <strong>{{ product.pivot.total | currency '$' }}</strong></h4>
                                                    <h5 class="font-blue"><s>{{ product.pivot.price | currency '$'}}</s></h5>
                                                    <h5 class="font-blue" v-show="product.price">{{product.price | currency '$' }} un</h5>
                                                </div>


                                            </div>
                                        </div>
                                        <i class="fa fa-close delete-product" v-on:click="deleteProduct(this)"></i>
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
        props:[
            'porder'
        ],
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
                order: {
                    products: {
                        pivot: {
                            products_amount: 0,
                            grids_amount: 0,
                            company_discount: 0,
                            representative_discount: 0,
                            representative_commission_total: 0,
                            representative_commission_price: 0,
                            representative_commission_percentage: 0,
                            representative_commission_descont: 0,
                            total_without_discount: 0,
                            total: 0,
                            company_total_discount:0,

                        },
                        cost: 0.00,
                        price: 0.00,
                        photo: '',
                    },
                    id: 0,
                    cost: 0,
                    price: 0,
                    representative_discount: 0,
                    company_discount: 0,
                    representative_commission_total: 0,
                    representative_commission_discount: 0,
                    representative_commission_price: 0,
                    representative_commission_percentage: 0.00,
                    company_total_discount: 0,
                    company_real_discount: 0,
                    products_amount: 0,
                    grids_amount: 0,
                    total_without_discount: 0,
                    total: 0,
                    total_discount: 0,
                    comment: '',
                    status_id: 1,
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
                _Order.updateOrder();
            },
            'order.company_discount': function (val, oldVal) {
                if (val) {
                    _Order.updateOrder();
                }
            },
            'order.status_id': function (val, oldVal) {
                if ((val != oldVal) && (val != null)) {
                    _Order.updateOrder();
                }
            },
            'order.representative_discount': function (val, oldVal) {
                if (val != oldVal) {
                    _Order.updateOrder();
                }
            },
            'order.representative_commission_company': function (val, oldVal) {
                if (val != oldVal) {
                    _Order.updateOrder();
                }
            },

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
            if (_Order.porder){
                _Order.loadOrder();
                _Order.porder = null;
            }
            _Order.getOrder();
        },
        methods: {
            loadOrder: function(){
              _Order.order = _Order.porder;
              this.$http.post('/shopping-cart/load-order', _Order.order)
                      .then(response => {
                          _Order.order = response.json();
                          console.log('pedido salvo');
                      })
                      .catch(response => {
                          console.log('pedido não salvo');
                      });
            },
            getUrl(){
                return window.location.pathname;
            },
            getProducts(){
                this.$http.get('/shopping-cart/get-products')
                        .then(response => {
                            _Order.order.products = response.json();
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
            updateOrder(){
                this.$http.post('/shopping-cart/update-order', _Order.order)
                        .then(response => {
                            _Order.order = response.json();
                            console.log('pedido salvo');
                        })
                        .catch(response => {
                            console.log('pedido não salvo');
                        });
            },
            deleteProduct(product){
                _Order.order.products.splice(product.$index, 1);
                console.log(product.$index);
                this.updateOrder();
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
            findProduct(product_id, grid_id){
                return _.find(_Order.order.products, function (obj) {
                    return (obj.id === product_id && obj.pivot.grid_id === grid_id);
                });
            },
            cancelOrder(){
                this.$http.post('/shopping-cart/stop-shopping')
                        .then( response => {
                            _Order.getOrder();
                        }).catch(response => {
                            toastr.error('No fué possible cancelar el pedido');
                        });
            },
            save(){
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
