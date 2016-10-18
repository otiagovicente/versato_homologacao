<style>
    div .product-list-photo{
        height: 50px;
        width: auto;
    }
</style>

<template>
    <div class="content">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Crear Pedido
                </div>
            </div>
            <div class="portlet-body form">
                
                <div class="row">
                    <div class="col-md-4">
                        <small>Cliente</small>
                        <div class="form-group form-line-input" id="client">
                            <v-select 
                                v-bind:options.sync="customers_select" :value.sync="order.customer_id"
                                placeholder="Elije el cliente" class="form-control"
                                id="customer-input" name="customer[]"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Representante</small>
                        <div class="form-group form-line-input" id="representative">
                            <v-select 
                                v-bind:options.sync="representatives_select" :value.sync="order.representative_id"
                                placeholder="Elije el representante" class="form-control"
                                id="representative-input" name="representative[]"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <small>Cliente Descuento</small>
                        <div class="form-group form-line-input" id="client_discount">
                            <input 
                                id="client-discount-input" 
                                class="form-control input-sm" 
                                type="number"
                                v-model="order.client_discount" 
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Representante Descuento</small>
                        <div class="form-group form-line-input" id="representative_discount">
                            <input              
                                id="representative-discount-input" 
                                class="form-control input-sm" 
                                type="number"
                                v-model="order.representative_discount" 
                            />
                        </div>
                    </div>
                </div>
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
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-md-3 pull-right">
                            <div class="form-group">
                                <button type="button" @click="submitData" class="btn blue btn-block" id="send-btn">Guardar</button>
                            </div>
                        </div>
                        <div class="col-md-3 pull-right">
                            <div class="form-group">
                                <a href="/orders/"><button type="button" class="btn grey btn-block" id="cancel-btn">Retornar</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Begin - Modal de Produtos -->
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
    <!--End - Modal de Produtos -->
    <pre>
        {{order | json}} 
    </pre>
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
        window._this = this;
        toastr.options.closeButton = true;
        _this.getCustomers();
        _this.getRepresentatives();
        _this.getProducts(Versato.brand_id);
        
        //if(this.porder) this.loadOrder();
    },
    methods:{
        deleteProduct: function(index){
            _this.orderProductsDelete.push(this.order.orderProducts[index]);
            _this.order.orderProducts.splice(index, 1);
        },

        updateOrderValues: function(){
            _this.order.cost = 0;
            _this.order.price = 0;
            _this.order.total = 0;
            _this.order.overalldiscount = 0;

            for (var i = 0; i < this.order.orderProducts.length; i++) {
                var finalPrice = this.calcFinalPrice(_this.order.orderProducts[i]);
                _this.order.orderProducts[i].total = finalPrice.finalPrice;
                _this.order.orderProducts[i].totaldiscount = finalPrice.totalDiscount;

                _this.order.cost            += parseFloat(_this.order.orderProducts[i].cost);
                _this.order.price           += parseFloat(_this.order.orderProducts[i].price);
                _this.order.total           += parseFloat(_this.order.orderProducts[i].total);
                _this.order.overalldiscount += parseFloat(_this.order.orderProducts[i].totaldiscount);
            }
        },
        addToProductList: function(product){
            var finalPrice = _this.calcFinalPrice(product);
            
            _this.order.orderProducts.push({
              id:product.id,
              code:product.code,
              cost:product.cost,
              price:product.price,
              chk_client_discount:false,
              chk_representative_discount:false,
              client_discount: product.client_discount,
              representative_discount: product.representative_discount,
              total: finalPrice.finalPrice,
              totaldiscount:finalPrice.totalDiscount,
            });
            return _this.order.orderProducts[_this.order.orderProducts.length - 1];
        },
        
        calcFinalPrice: function(product){
            var finalPrice              = {finalPrice:0, totalDiscount:0};
            var finalDiscount           = 0;
            var totalGeneralDiscount    = 0;
            var totalIndividualDiscount = 0;

            totalGeneralDiscount    = _this.calcGeneralDiscount();
            totalIndividualDiscount = _this.calcIndidualDiscount(product);
            
            finalDiscount = totalIndividualDiscount? totalIndividualDiscount : totalGeneralDiscount;
            
            finalPrice.totalDiscount = ((parseFloat(finalDiscount)/100) * parseFloat(product.price));
            finalPrice.finalPrice = (parseFloat(product.price) - parseFloat(finalPrice.totalDiscount));
            
            return finalPrice;
        },
        calcGeneralDiscount: function(){
            var client_discount         = _this.order.client_discount         ? _this.order.client_discount         : 0;
            var representative_discount = _this.order.representative_discount ? _this.order.representative_discount : 0;
            return parseFloat(client_discount) + parseFloat(representative_discount);
        },
        calcIndidualDiscount: function(product){
            var client_discount         = product.client_discount         ? product.client_discount         : 0;
            var representative_discount = product.representative_discount ? product.representative_discount : 0;
            return parseFloat(client_discount) + parseFloat(representative_discount);
        },
        getProducts:function(brandid){
            this.$http.get('/api/products/list/'+brandid)
            .then(response => {
                _this.products = response.data;
            });
        },
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

        submitData: function(){
            if(!_this.order.id)
                _this.insertData();
            else
                _this.updateData();
        },
        
        insertData: function(){
            this.$http.post('/orders', _this.order)
            .then((response) => {
              toastr.success('Sucesso!','Pedido creado con sucesso!');
            }, (response) => { 
              _this.showErrors(response.data); 
            });
        },
        
        updateData: function(){
          this.$http.put('/orders/'+_this.order.id, _this.order)
          .then((response) => {
            toastr.success('Sucesso!','Pedido atualizado con sucesso!');
          }, (response) => { 
            _this.showErrors(response.data); 
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
        'order.orderProducts': function (val, oldVal) {
            _this.updateOrderValues();
        },
        'order.client_discount': function(val, oldVal){
            _this.updateOrderValues();
        },
        'order.representative_discount': function(val, oldVal){
            _this.updateOrderValues();
        },
    },
}
</script>