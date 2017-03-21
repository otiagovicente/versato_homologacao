<style>

</style>

<template>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <span class="caption-subject font-blue bold uppercase"> <i class="fa fa-user"></i>Informe de Órdenes - El Cliente</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div id="code-input" class="form-group" >
                        <label class="col-md-3 control-label">Cliente</label>
                        <div class="col-md-7" id="client">
                            <v-select
                                v-bind:options.sync="customers_select" :value.sync="order.customer_id"
                                placeholder="Elige el cliente" class="form-control"
                                id="customer-input" name="customer[]"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                    <div id="code-input" class="form-group" >
                        <label class="col-md-3 control-label">Representante</label>
                        <div class="col-md-7" id="representative">
                            <v-select
                                v-bind:options.sync="representatives_select" :value.sync="order.representative_id"
                                placeholder="Elige el representante" class="form-control"
                                id="representative-input" name="representative[]"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import toastr   from 'toastr'
    import VueStrap from 'vue-strap'

    export default{
        props:[
            'porder'
        ],

        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option
        },

        data(){
            return{

                customers_select:[],
                representatives_select:[],
                brands_select:[],
                deliverycenters_select:[],
                products:[],
                orderProductsDelete:[],

                order: {
                    id:'',
                    cost:0,
                    price:0,
                    total:0,
                    overalldiscount:0,
                    representative_comision:0,
                    representative_discount:0,
                    client_discount:0,
                    status_id:1,
                    customer_id:[],
                    representative_id:[],
                    products:[],
                    delivery_id:[],
                    comment: '',
                },
            }
        },
        ready(){
            window._this = this;
            toastr.options.closeButton = true;
            _this.getCustomers();
            _this.getRepresentatives();
            //_this.getProducts(Versato.brand_id);

            if(_this.porder) _this.loadOrder();
        },
        methods:{
            getCustomers: function(){
                this.$http.get('/api/customers/selectlist')
                .then(response => {
                    _this.customers_select = response.json();
                });
            },
            getRepresentatives: function(){
                this.$http.get('/api/representatives/selectlist')
                .then(response => {
                    _this.representatives_select = response.json();
                });
            },
        },

        watch: {

        },
    }
</script>