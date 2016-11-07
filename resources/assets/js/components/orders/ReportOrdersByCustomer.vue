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
                        <label class="col-md-3 control-label">Nome</label>
                        <div class="col-md-7" id="code">
                            <input type="text"
                                   name="code"
                                   class="form-control"
                                   placeholder="Nombre"
                            >
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
            //_this.getCustomers();
            //_this.getRepresentatives();
            //_this.getProducts(Versato.brand_id);

            if(_this.porder) _this.loadOrder();
        },
        methods:{

        },

        watch: {

        },
    }
</script>