<style>
    div .product-list-photo{
        height: 50px;
        width: auto;
    }
</style>

<template>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered" id="form_wizard_1">        
                <div class="portlet-body form">
                    <form class="form-horizontal" action="#" id="submit_form" method="POST">
                        <div class="form-wizard">
                            <div class="form-body">
                                <ul class="nav nav-pills nav-justified steps">
                                    <li>
                                        <a href="#tab1" data-toggle="tab" class="step">
                                            <span class="number"> 1 </span>
                                            <span class="desc">
                                            <i class="fa fa-check"></i> Dados Basicos </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab2" data-toggle="tab" class="step">
                                            <span class="number"> 2 </span>
                                            <span class="desc">
                                            <i class="fa fa-check"></i> Productos </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab3" data-toggle="tab" class="step">
                                            <span class="number"> 3 </span>
                                            <span class="desc">
                                            <i class="fa fa-check"></i> Confirmar </span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="bar" class="progress progress-striped" role="progressbar">
                                    <div class="progress-bar progress-bar-success"> </div>
                                </div>
                                <div class="tab-content">
                                    <div class="alert alert-danger display-none">
                                        <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below.
                                    </div>
                                    <div class="alert alert-success display-none">
                                        <button class="close" data-dismiss="alert"></button> Your form validation is successful! 
                                    </div>
                                    
                                    <div class="tab-pane active" id="tab1">
                                        <h3 class="block">Provide your account details</h3>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Cliente
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <v-select 
                                                    v-bind:options.sync="customers_select" :value.sync="order.customer_id"
                                                    placeholder="Elije el cliente" class="form-control"
                                                    id="customer-input" name="customer[]"
                                                    search justified required close-on-select>
                                                </v-select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Representante
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <v-select 
                                                    v-bind:options.sync="representatives_select" :value.sync="order.representative_id"
                                                    placeholder="Elije el representante" class="form-control"
                                                    id="representative-input" name="representative[]"
                                                    search justified required close-on-select>
                                                </v-select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="tab-pane" id="tab2">
                                        <h3 class="block"></h3>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Descuento Cliente
                                            </label>
                                            <div class="col-md-4">
                                                <input 
                                                    contenteditable="false"
                                                    id="code-input" 
                                                    class="form-control input-sm" 
                                                    type="number"
                                                    v-model="order.client_discount" 
                                                />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Descuento Representante
                                            </label>
                                            <div class="col-md-4">
                                                <input 
                                                    contenteditable="false"
                                                    id="code-input" 
                                                    class="form-control input-sm" 
                                                    type="number"
                                                    v-model="order.representative_discount" 
                                                />
                                            </div>
                                        </div>
                                        
                                        <hr/>
                                        
                                        <div class="row">
                                            <fieldset class="form-group">
                                                <legend>Productos</legend>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="pull-right">
                                                            <a class="btn blue btn-outline sbold" 
                                                                data-toggle="modal" 
                                                                href="#large"
                                                            > 
                                                                Adicionar Producto 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Costo</th>
                                                            <th>Precio</th>
                                                            <th>Descuento Cliente</th>
                                                            <th>Descuento Representante</th>
                                                            <th>Total</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="op in order.orderProducts">
                                                            <td>{{op.code}}</td>
                                                            <td>{{op.cost}}</td>
                                                            <td>{{op.price}}</td>
                                                            <td>{{op.client_discount}}</td>
                                                            <td>{{op.representative_discount}}</td>
                                                            <td>{{op.total}}</td>
                                                            <td>
                                                                <button 
                                                                    class="btn grey"
                                                                    @click="deleteProduct($index)"
                                                                >
                                                                    Excluir
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                        </div>
                                    </div>
                            

                                    <div class="tab-pane" id="tab3">
                                        <h3 class="block">Confirme el pedido</h3>
                                        <h4 class="form-section">Dados Basicos</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Username:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="username"> </p>
                                            </div>
                                        </div>
                                        <h4 class="form-section">Productos</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Fullname:</label>
                                            <div class="col-md-4">
                                                <p class="form-control-static" data-display="fullname"> </p>
                                            </div>
                                        </div>
                                        <h4 class="form-section">Totales</h4>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Card Holder Name:</label>
                                            <div class="col-md-4">
                                            <p class="form-control-static" data-display="card_name"> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a href="javascript:;" class="btn default button-previous">
                                            <i class="fa fa-angle-left"></i>
                                            Retorno 
                                        </a>
                                        <a href="javascript:;" class="btn btn-outline green button-next"> 
                                            Continue
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                        <a href="javascript:;" class="btn green button-submit">
                                            Guardar
                                            <i class="fa fa-check"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    



    <div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Productos</h4>
                </div>
                
                <div class="modal-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Producto</>
                                <th>Costo</th>
                                <th>Precio</th>
                                <th>Descuento Cliente</th>
                                <th>Descuento Representante</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="p in products">
                                <td>
                                    <img class="product-list-photo" :src="p.photo" :alt="p.code" />
                                    <br/>
                                    <small>{{p.code}}</small>
                                </td>
                                <td>{{p.cost}}</td>
                                <td>{{p.price}}</td>
                                <td>
                                    <input 
                                        id="code-input" 
                                        class="form-control input-sm" 
                                        type="number"
                                        v-model="p.client_discount" 
                                    />
                                </td>
                                <td>
                                    <input 
                                        id="code-input" 
                                        class="form-control input-sm" 
                                        type="number"
                                        v-model="p.representative_discount" 
                                    />
                                </td>
                                <td>
                                    <a
                                        class="btn blue btn-outline sbold" 
                                        data-toggle="modal" 
                                        href="#large"
                                        @click="addToProductList(p)"
                                    > 
                                        Selecionar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                            </table>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import toastr from 'toastr'
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
            brand_id:[],
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
                status_id:[],
                customer_id:[],
                representative_id:[],
                orderProducts:[]
            },
        }
    },
    ready(){
        toastr.options.closeButton = true;
        
        this.getCustomers();
        this.getRepresentatives();
        this.getBrands();
        this.getProducts(Versato.brand_id);
        //if(this.porder) this.loadOrder();
    },
    methods:{
        deleteProduct: function(index){
            this.orderProductsDelete.push(this.order.orderProducts[index]);
            this.order.orderProducts.splice(index, 1);
        },

        addToProductList: function(product){
            product.client_discount = product.client_discount ? product.client_discount : 0;
            product.representative_discount = product.representative_discount ? product.representative_discount : 0;
            
            var totalDiscount = parseFloat(product.client_discount) + parseFloat(product.representative_discount);
            var finalPrice = (parseFloat(product.price) - ((parseFloat(totalDiscount)/100) * parseFloat(product.price)));

            this.order.orderProducts.push({
              id:product.id,
              code:product.code,
              cost:product.cost,
              price:product.price,
              client_discount: product.client_discount,
              representative_discount: product.representative_discount,
              total: finalPrice
            });
            return this.order.orderProducts[this.order.orderProducts.length - 1];
        },
        
        getBrands:function(representative_id){
            //selectListByRepresentativeId
            this.$http.get('/api/brands/selectlist')
            .then(response => {
                this.brands_select = response.json();
            });
        },

        getProducts:function(brandid){
            this.$http.get('/api/products/list/'+brandid)
            .then(response => {
                this.products = response.data;
            });
        },

        getCustomers: function(){
            this.$http.get('/api/customers/selectlist')
            .then(response => {
                this.customers_select = response.json();
            });
        },

        getRepresentatives: function(){
            this.$http.get('/api/representatives/selectlist')
            .then(response => {
                this.representatives_select = response.json();
            });
        },

        submitData: function(){

        },
        
        insertData: function(){
            this.$http.post('/orders', this.order)
            .then((response) => {
              toastr.success('Sucesso!','Pedido creado con sucesso!');
            }, (response) => { 
              this.showErrors(response.data); 
            }); 
        },
        
        updateData: function(){
          this.$http.put('/orders/'+this.order.id, this.order)
          .then((response) => {
            toastr.success('Sucesso!','Pedido atualizado con sucesso!');
          }, (response) => { 
            this.showErrors(response.data); 
          }); 
        },
        
        showErrors: function(data){
          $.each(data, function (key, value) {
            toastr.warning('Atención', value);
            $('#'+key).addClass('has-error');
          }); 
        },
    },

    watch: {
        'brand_id': function (val, oldVal) {
            if(this.brand_id) this.getProducts(this.brand_id);
        },
        'order.orderProducts': function (val, oldVal) {
            var CostTotal = 0;
            var PriceTotal = 0;
            var Total = 0;

            for (var i = 0; i < this.order.orderProducts.length; i++) {
                CostTotal += parseFloat(this.order.orderProducts[i].cost);
                PriceTotal += parseFloat(this.order.orderProducts[i].price);
                Total += parseFloat(this.order.orderProducts[i].total);
            }

            this.order.cost  = CostTotal;
            this.order.price = PriceTotal;
            this.order.total = Total;
        },
        'order.representative_id': function (val, oldVal) {
            
            //if(val && oldVal != null)
                //this.order.orderProducts = [];
            //else
              //  this.order.representative_id = [oldVal];

                //bootbox.confirm('Cambiar representante?', function(response){
                //});      
        }
    },
}
</script>