<template>
    <div>
        <div class="modal fade" id="filter-add-customer" tabindex="-1" role="filter-add-customer" aria-hidden="true" style="display: none;">
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
            return {
                customers: {},
                search: ''
            }
        },
        props: {
            customer_id: {
                twoWay: true
            }
        },
        ready(){
            window._FilterAddCustomer = this;
        },
        methods: {
            searchCustomers(){
                this.$http.get('/api/customers/search?search=' + _FilterAddCustomer.search)
                        .then(response => {
                            this.customers = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar los clientes');
                        }).bind(this);
            },
            selectCustomer(customer_id){

                _FilterAddCustomer.customer_id = customer_id;
                this.$dispatch('reload-orders');
                _FilterAddCustomer.closeWindow();

            },

            /*
             *  Funções de Janela
             */
            openWindow(){
                $('#filter-add-customer').on("hide.bs.modal", function (e) {
                    _FilterAddCustomer.reload();
                });
                $('#filter-add-customer').modal();

            },
            closeWindow(){
                $('#filter-add-customer').modal('hide');
            },
            reload(){

                _FilterAddCustomer.search = "";
                _FilterAddCustomer.customers = {};
            },
        }
    }
</script>
