<template>
    <div>
        <div class="modal fade" id="order-add-customer" tabindex="-1" role="order-add-customer" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="font-blue uppercase">Clientes</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-line-input search">
                                        <div class="input-icon input-icon-lg right">
                                            <i class="fa fa-search font-blue"></i>
                                            <input id="search-input" class="form-control input-lg" placeholder="Buscar" type="text" v-model="search" v-on:keyup.enter="searchCustomers()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 customers-list">
                                    <div class="col-md-12 customers-list-box" v-for="customer in customers" v-on:click="selectCustomer(customer.id)">
                                        <h3 class="font-blue"><strong>{{ customer.name }}</strong></h3>
                                        <h4>{{customer.company}} <small>cuit: {{customer.cuit}}</small></h4>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">

                        </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style scoped>
    .customers-list{
        height: 500px;
        overflow : scroll;
    }
    .customers-list-box:hover{
        background-color: #eaeaea;
        cursor: pointer;
    }
</style>
<script type="text/babel">
    export default{
        data(){
            return{
                customers: {},
                search: ''
            }
        },
        ready(){
            window._OrderAddCustomer = this;
        },
        methods: {
            searchCustomers(){
                this.$http.get('/api/customers/search?search='+_OrderAddCustomer.search)
                        .then(response => {
                            this.customers = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar los clientes');
                        }).bind(this);
            },
            selectCustomer(customer_id){
                this.$http.post('/shopping-cart/select-customer/'+customer_id)
                        .then(response => {
                            toastr.success('Cliente eligido con exito');
                            this.$dispatch('load-order');
                            _OrderAddCustomer.closeWindow();
                        })
                        .catch(response => {
                            toastr.error('No fué possible eligir el cliente');
                        });


            },

            /*
             *  Funções de Janela
             */
            openWindow(){
                $('#order-add-customer').on("hide.bs.modal", function (e) {
                    _OrderAddCustomer.reload();
                });
                $('#order-add-customer').modal();

            },
            closeWindow(){
                $('#order-add-customer').modal('hide');
            },
            reload(){

                _OrderAddCustomer.search = "";
                _OrderAddCustomer.customers = {};
            },
        }
    }
</script>
