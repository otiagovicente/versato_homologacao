<template>
    <div class="content-fluid" style="padding:20px;">
        <div class="row">
            <div class="col-md-12">
                <div class="page-bar">
                    <div class="col-md-6">
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
                                <a href="/orders">Buscar</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="page-toolbar col-md-12">
                            <div class="btn-group col-md-9 pull-right">
                                <date-range-picker v-bind:start_date.sync="filters.start_date" v-bind:end_date.sync="filters.end_date"></date-range-picker>
                            </div>
                        </div>
                    </div>

                </div>
                <h1>Pedidos</h1>

            </div>

        </div>
        <br>


        <div class="row">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green-sharp">
                        <i class="icon-speech font-green-sharp"></i>
                        <span class="caption-subject bold uppercase"> Pedidos</span>
                        <span class="caption-helper">Filtros...</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn btn-circle btn-default btn-sm">
                            <i class="fa fa-pencil"></i> Edit </a>
                        <a href="javascript:;" class="btn btn-circle btn-default btn-sm">
                            <i class="fa fa-plus"></i> Add </a>

                        <a href="javascript:;" v-on:click="paginate(orders.prev_page_url)" v-show="orders.prev_page_url" class="btn btn-circle btn-default btn-sm">
                            <i class="fa fa-long-arrow-left"></i></a>

                        <a  v-for="page in paginationlinks" track-by="$index" href="javascript:;" v-on:click="paginate(page['0'])" class="btn btn-circle btn-default btn-sm">
                            {{ page['1'] }} </a>


                        <a href="javascript:;" v-on:click="paginate(orders.next_page_url)" v-show="orders.next_page_url" class="btn btn-circle btn-default btn-sm">
                            <i class="fa fa-long-arrow-right"></i></a>

                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group form-line-input search ">
                                        <div class="input-icon input-icon right">
                                            <i class="fa fa-search font-blue"></i>
                                            <input id="search-input" class="form-control input" placeholder="Buscar" type="text" v-model="filters.search" v-on:keyup.enter="searchOrders()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 form-group">
                                    <button v-if="representative.id" class="btn blue" v-on:click="emptyRepresentativeFilter()">{{ representative.code+' - '+representative.user.name+' '+representative.user.lastname }}</button>
                                    <button v-else class="btn btn-outline grey" v-on:click="filterRepresentative()">Filtrar Representante</button>

                                    <button v-if="customer.id" class="btn blue" v-on:click="emptyCustomerFilter()">{{ customer.name+' - '+customer.company}}</button>
                                    <button v-else class="btn btn-outline grey" v-on:click="filterCustomer()" style="margin-right:10px;">Filtrar Cliente</button>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="btn-group pull-right">
                                            <color-button :data="statuses" :option.sync="filters.status" v-on:update="searchOrders()"></color-button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="order mt-element-ribbon" v-for="order in orders.data">
                                <hr v-show="$index > 0">
                                <div class="ribbon ribbon-shadow blue-madison"><strong>#{{ order.id }}</strong></div>

                                <div class="cutomer-info">
                                    <h3>{{order.customer.name}}</h3>
                                    <h5>{{order.customer.company}}</h5>
                                    <div class="customer-discount-info">
                                        <div class="customer-discount-slider">
                                            <slider-component :slider_value.sync="order.customer_discount" :slider_width="50" :slider_max="10"></slider-component>
                                        </div>
                                        <div class="customer-discount-amount">
                                            <span class="h4">{{order.customer_discount | currency '$'}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="representative-info">

                                    <div class="representative-info-photo">
                                        <img v-bind:src="order.representative.user.photo" class="representative-photo">
                                    </div>
                                    <div class="representative-name">
                                        <span class="small">{{ order.representative.user.name+' '+order.representative.user.lastname }}</span>
                                    </div>
                                    <div class="representative-discount-info">
                                        <div class="representative-discount-slider">
                                            <slider-component :slider_value.sync="order.representative_discount" :slider_width="50" :slider_max="10"></slider-component>

                                        </div>
                                        <div class="representative-discount-amount">
                                            <span class="h4">{{order.representative_commission_discount | currency '$'}}</span>

                                        </div>
                                    </div>
                                </div>

                                        <div class="values-info">
                                                <span class="h2"><strong>{{order.total | currency '$'}}</strong></span><br>
                                                <span class="h5 font-red"><s>{{order.price | currency '$'}}</s></span><br>
                                                <span class="small font-grey">- {{order.overalldiscount | currency '$'}}</span><br>
                                                <span class="small"> {{order.amount}} modelos.</span>

                                        </div>

                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>



    <filter-add-customer v-bind:customer_id.sync="filters.customer_id"></filter-add-customer>
    <filter-add-representative v-bind:representative_id.sync="filters.representative_id"></filter-add-representative>
</template>
<style scoped>


    .order{
        width:100%;
        height: 200px;
        position: relative;
        color: #3598DC;
        display : flex;
        align-items : center;
        justify-content : space-between;
        padding : 20px;
    }
    .order:hover{
        color : #FFFFFF;
        background-color: #3598DC;
        cursor: pointer;

    }


    .order .ribbon {
        background-color : #eaeaea !important;
    }
    .order .representative-info{
        width: auto;
        height: auto;
    }
    .order .representative-info .representative-name{
        display : inline;
        position : relative;
        left : 10px;
    }

    .order .representative-info .representative-info-photo{
        display : inline;
        text-align : center;
    }
    .order .representative-info .representative-info-photo .representative-photo{
        clip-path: circle(25px at center);
        width: auto;
        height:50px;
        position : relative;
    }
    .order .representative-info .representative-discount-info{
        position : relative;
        padding-top : 10px;
        /*top: 60px;*/
    }
    .order .representative-info .representative-discount-info .representative-discount-slider{
        width : 60px;
        position : relative;
    }
    .order .representative-info .representative-discount-info .representative-discount-amount{
        position : relative;
        left : 70px;
    }


    .order .cutomer-info{
         width: 200px;
        height: auto;
    }

    .order .cutomer-info h3{
        font-weight: bold;
    }
    .order .cutomer-info h5{

    }
    .order .cutomer-info .customer-discount-info{
        position : relative;
    }
    .order .cutomer-info .customer-discount-info .customer-discount-slider{
        width: 60px;
        position : relative;
    }
        .order .cutomer-info .customer-discount-info .customer-discount-amount{
        position : relative;
        left : 70px;
    }

    .order .order-id{
        top : 40px;
    }

    .order .values-info{
        text-align: right;
    }
    @media (max-width: 600px) {
      .order {
        background-color : #FFF;
      }
    }

</style>
<script type="text/babel">

    import FilterAddCustomer from './FilterAddCustomer.vue'
    import FilterAddRepresentative from './FilterAddRepresentative.vue'
    import ColorButton from './../general/buttons/ColorButton.vue'
    import DateRangePicker from './../general/dates/daterangepicker.vue'
    import Slider from '../general/sliders/Slider.vue'

    export default{
        data(){
            return{
                orders: {},
                url : '',
                paginationlinks : [],
                statuses : [],
                filters : {
                    customer_id : null,
                    representative_id : null,
                    brand_id: Versato.brand_id ,
                    status_id: 1,
                    status: {},
                    start_date : moment().subtract('days', 29),
                    end_date : moment(),
                    search: ''
                },
                customer : {
                    name : '',
                    company : ''
                },
                representative: {
                    code : '',
                    user : {
                        name : '',
                        lastname : ''
                    }
                }
            }
        },
        watch: {
            'filters.customer_id': function (val) {
                if (val) {
                    _ListOrders.getCustomer();
                }else{
                    _ListOrders.customer = null;
                    _ListOrders.searchOrders();
                }
            },
            'filters.representative_id': function (val) {
                if (val) {
                    _ListOrders.getRepresentative();
                }else{
                    _ListOrders.representative = null;
                    _ListOrders.searchOrders();
                }
            },
            'filters.start_date': function (val) {
                if (val) {
                    _ListOrders.searchOrders();
                }else{
                    _ListOrders.start_date = moment().subtract('days', 29);
                    _ListOrders.searchOrders();
                }
            },
            'filters.end_date': function (val) {
                if (val) {
                    _ListOrders.searchOrders();
                }else{
                    _ListOrders.end_date = moment();
                    _ListOrders.searchOrders();
                }
            },
            'filters.status_id': function (val) {
                if (val != null){
                    _ListOrders.searchOrders();
                }

            },
            'filters.status': function(val){
                if (val != null) {
                    _ListOrders.filters.status_id = val.id;
                }
            }
        },
        components:{
            'filter-add-customer' : FilterAddCustomer,
            'filter-add-representative' : FilterAddRepresentative,
            'color-button' : ColorButton,
            'date-range-picker' : DateRangePicker,
            'slider-component': Slider,
        },
        ready(){
            window._ListOrders = this;
            _ListOrders.getStatuses();
            _ListOrders.getOrders();
        },
        methods : {
            getUrl(){
                return window.location.pathname;
            },
            loadOrder(order_id){
                this.$http.get('/shopping-cart/order/'+order_id)
                        .then(response => {
                            toastr.success('Cargo el pedido!');
                            // window.location.href = "/orders/create";
                        }).catch(response => {
                            toastr.error('No fué possible cargar el pedido');
                        });
            },
            getOrders(){
                _ListOrders.reload();
                _ListOrders.url = '/api/orders/search';
                _ListOrders.paginate('/api/orders/search');
            },
            getStatuses(){
                this.$http.get('/api/orderstatus')
                        .then(response => {
                            _ListOrders.statuses = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fué possible cargar los status');
                        });
            },
            getCustomer(){
                this.$http.get('/api/customers/'+_ListOrders.filters.customer_id)
                        .then(response => {
                            _ListOrders.customer = response.json();
                        }).catch(response => {
                    toastr.error('No fué possible cargar el Cliente');
                });
                _ListOrders.searchOrders();
            },
            filterCustomer(){
                _FilterAddCustomer.openWindow();
            },
            emptyCustomerFilter(){
                _ListOrders.filters.customer_id = null;
            },
            getRepresentative(){
                this.$http.get('/api/representatives/'+_ListOrders.filters.representative_id)
                        .then(response => {
                            _ListOrders.representative = response.json();
                        }).catch(response => {
                    toastr.error('No fué possible cargar el Cliente');
                });
                _ListOrders.searchOrders();
            },
            filterRepresentative(){
                _FilterAddRepresentative.openWindow();
            },
            emptyRepresentativeFilter(){
                _ListOrders.filters.representative_id = null;
            },
            setStatus(status_id){

                $('#status_id li').removeClass('active');
                $('#status-'+status_id).addClass('active');
                _ListOrders.filters.status_id = status_id;
                _ListOrders.searchOrders();
            },
            buildpaginationlinks(){
                _ListOrders.paginationlinks = [];

                var arr = [];
                for (var i = 0; i < _ListOrders.orders.last_page; i++) {
                    arr.push(_ListOrders.url+'?page='+(i + 1));
                    arr.push((i+1));
                    _ListOrders.paginationlinks.push(arr);
                    arr = [];

                }

            },
            searchOrders(){
                _ListOrders.url = '/api/orders/search';
                _ListOrders.paginate('/api/orders/search');
            },
            paginate(paginationUrl){

                this.$http.post(paginationUrl, _ListOrders.filters)
                        .then(response => {
                            _ListOrders.orders = response.json();
                            _ListOrders.buildpaginationlinks();
                        })
                        .catch(response => {
                            toastr.error('no fue possible cargar los pedidos');
                        });

            },
            reload(){

                _ListOrders.$data = {
                    orders: {},
                    statuses: [],
                    url : '',
                    paginationlinks : [],
                    filters : {
                        customer_id : null,
                        representative_id : null,
                        brand_id: null,
                        search: ''
                    },
                    customer : {
                        name : '',
                        company : ''
                    },
                    representative: {
                        code : '',
                        user : {
                            name : '',
                            lastname : ''
                        }
                    }
                };
            }
        }
    }
</script>
