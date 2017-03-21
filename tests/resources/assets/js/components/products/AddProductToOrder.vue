<style scoped>

    .product-photo {
        width:400px;
    }

    .form-margin{
        margin-top: 5px;
        margin-bottom: 5px;
    }

</style>

<template>

    <div class="modal fade" id="add-product-to-order" tabindex="-1" role="add-product-to-order" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h3 class="caption-subject font-blue-madison bold uppercase">{{product.line.description +' '+ product.material.description + ' ' + product.color.description}}</h3>
                </div>
                <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12 center-block">
                                <img v-bind:src="product.photo" class="product-photo center-block" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-margin">
                                <div class="col-md-6">Precio</div>
                                <div class="col-md-6">ARS {{product.price}}</div>
                            </div>
                            <div class="col-md-12 form-margin">
                                <div class="col-md-6">Cantidad</div>
                                <div class="col-md-6">
                                    <div class="input-group" id="amount">
                                        <input class="form-control" type="number" min="1" v-model="addProduct.amount">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 form-margin">
                                <div class="col-md-6">Tarea</div>
                                <div class="col-md-6">
                                    <div class="input-group" id="grid">

                                        <select v-model="addProduct.grid" class="form-control">
                                            <option v-for="option in grids" v-bind:value="option.value">
                                                {{ option.label }}
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-5 pull-right">
                            <div class="form-group">
                                <button type="button" @click="submitData" class="btn blue btn-block" id="send-btn">
                                    Agregar al Pedido
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 pull-right">
                            <div class="form-group">
                                <button type="button" class="btn grey btn-block"  id="cancel-btn" v-on:click="closeWindow()">Cerrar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</template>

<script type="text/babel">
    import toastr from 'toastr'

    export default{

        data(){
            return {

                grids:{},
                addProduct:{
                    amount: 1,
                    grid: null,
                    product: null,
                    discount : 0.00,
                    representativeDiscount: 0.00,
                },
                product: {
                    line: {
                        description : ''
                    },
                    material: {
                        description : ''
                    },
                    color: {
                        description : ''
                    },
                },
            }
        },
        ready(){
            window._AddProductToOrder = this;

            toastr.options.closeButton = true;

        },
        methods:{

            /*
             *  Funções de carregamento
             */
            loadProduct(product_id){
                this.$http.get('/api/products/'+ product_id)
                        .then(response => {
                            _AddProductToOrder.product = response.json();
                            _AddProductToOrder.addProduct.product = _AddProductToOrder.product.id;
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar el producto');
                        });
            },
            loadGrids(){

                this.$http.get('/api/grids/selectlist/' + Versato.brand_id)
                        .then(response => {
                            _AddProductToOrder.grids = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar las tareas');
                        });

            },


            /*
             *  Funções de Janela
             */
            openWindow: function (product_id) {
                $("#add-product-to-order").on("hide.bs.modal", function (e) {
                    _AddProductToOrder.reload();
                });

                if (product_id) {
                    _AddProductToOrder.loadGrids();
                    _AddProductToOrder.loadProduct(product_id);

                }
                $('#add-product-to-order').modal();
            },
            closeWindow: function () {
                $('#add-product-to-order').modal('hide');
            },
            reload(){

                _AddProductToOrder.addProduct.amount = 1;
                _AddProductToOrder.addProduct.product = null;
                _AddProductToOrder.addProduct.discount = 0.00;
                _AddProductToOrder.addProduct.representativeDiscount = 0.00;
                _AddProductToOrder.product = {
                    line: {
                        description : ''
                    },
                    material: {
                        description : ''
                    },
                    color: {
                        description : ''
                    },
                };
            },
            /*
             * Funções de Envio
             */
            submitData(){
                this.$http.post('/shopping-cart/add-product', _AddProductToOrder.addProduct)
                        .then(response => {
                            // console.log('deu certo');
                            // response.json();
                            toastr.success(_AddProductToOrder.product.line.description+' '+_AddProductToOrder.product.material.description+' '+_AddProductToOrder.product.color.description+ ' agregado');
                            _AddProductToOrder.closeWindow();
                        })
                        .catch(response => {
                            $.each(response.json(), function (key, value) {
                                toastr.error(value);
                                $('#'+key).addClass('has-error');
                            });
                        });
            }

        },
        filters: {}
    }
</script>