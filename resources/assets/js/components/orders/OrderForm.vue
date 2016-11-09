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
                    <form class="form-horizontal" id="submit_form">
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
                                        <h3 class="block"></h3>
                                        
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
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Centro de Distribuicion
                                                </label>
                                                <div class="col-md-4">
                                                    <v-select
                                                            v-bind:options.sync="deliverycenters_select" :value.sync="order.delivery_id"
                                                            placeholder="Elije el cebtro de distruicion" class="form-control"
                                                            id="customer-input" name="customer[]"
                                                            search justified required close-on-select>
                                                    </v-select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        
                                        <div class="row">
                                            <fieldset>
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
                                                            <th>Producto</th>
                                                            <th>Costo</th>
                                                            <th>Precio</th>
                                                            <th>Grid</th>
                                                            <th>Desc. Cliente</th>
                                                            <th>Desc. Representante</th>
                                                            <th>Total</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="op in order.products">
                                                            <td>{{op.strLine}} {{op.strMaterial}} {{op.strColor}}</td>
                                                            <td>{{op.cost | currency}}</td>
                                                            <td>{{op.price | currency}}</td>
                                                            <td>{{op.strGrid}}</td>
                                                            <td>{{op.client_discount}}</td>
                                                            <td>{{op.representative_discount}}</td>
                                                            <td>{{op.total | currency}}</td>
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
                                        <div class="form-group">
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7" style="text-align:center"><b>Geral</b></th>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th colspan="3">Descuento Cliente: {{order.client_discount}}%</th>
                                                        <th colspan="4">Descuento Representante: {{order.representative_discount}}%</th>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th colspan="7" style="text-align:center"><b>Productos</b></th>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th style="width: 400px">Producto</th>
                                                        <th>Costo</th>
                                                        <th>Precio</th>
                                                        <th>Grid</th>
                                                        <th>Descuento Cliente</th>
                                                        <th>Descuento Representante</th>
                                                        <th style="width: 100px"><i class="fa fa-shopping-cart"></i> Total</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th style="text-align:left">Totales</th>
                                                        <th style="text-align:center">{{order.cost | currency}}</th>
                                                        <th style="text-align:center">{{order.price | currency}}</th>
                                                        <th colspan="4" style="text-align:center">Total:&nbsp;&nbsp; {{order.total | currency}}</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <tr v-for="op in order.products">
                                                        <td>{{op.strLine}} {{op.strMaterial}} {{op.strColor}}</td>
                                                        <td style="text-align:right">{{op.cost | currency}}</td>
                                                        <td style="text-align:right">{{op.price | currency}}</td>
                                                        <td style="text-align:center">{{op.strGrid}}</td>
                                                        <td style="text-align:center">{{op.client_discount}}%</td>
                                                        <td style="text-align:center">{{op.representative_discount}}%</td>
                                                        <td>{{op.total | currency}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            Comentário
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <textarea class="form-control" rows="3" v-model="order.comment"></textarea>
                                                </div>
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

                                        <a href="javascript:;" class="btn btn-outline blue button-next">
                                            Continue
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                        <a @click="submitData" class="btn btn-outline blue button-submit">
                                            Guardar
                                            <i class="fa fa-angle-right"></i>
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
                                <th>Desc. Cliente</th>
                                <th>Desc. Representante</th>
                                <th>Grid</th>
                                <th>Qtd.</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="p in products">
                                <td>
                                    <img class="product-list-photo" :src="p.photo" :alt="p.code" />
                                    <br/>
                                    <small>{{p.line.description}} / {{p.material.description}} / {{p.color.description}}</small>
                                </td>
                                <td>{{p.cost  | currency}}</td>
                                <td>{{p.price | currency}}</td>
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
                                    <v-select
                                        v-bind:options.sync="p.grids_select" :value.sync="p.grid_id" :selected.sync="p.strGrid"
                                        placeholder="grid" class="form-control"
                                        id="customer-input" name="customer[]"
                                        search justified required close-on-select>
                                    </v-select>

                                </td>
                                <td>
                                    <input
                                            id="code-input"
                                            class="form-control input-sm"
                                            type="number"
                                            v-model="p.qtd"
                                    />
                                </td>
                                <td>
                                    <a
                                        class="btn blue btn-outline sbold" 
                                        data-toggle="modal"
                                        v-show="p.grid_id"
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
</template>

<script type="text/babel">
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

        //if(_this.porder) _this.loadOrder();
    },
    methods:{
        loadOrder: function(){
            _this.order.id = _this.porder.id;
            _this.order.comment = _this.porder.comment;
            _this.order.representative_comision= _this.porder.representative_comision;
            _this.order.representative_discount=0;
            client_discount=0;
            status_id=1;
            customer_id=[];
            representative_id=[];
            products=[];
            delivery_id=[];
        },
        getOrderProducts: function(id){
            //this.$http.get('/api/orders/getProductsFromOrder/'+_this.porder.id).then(response => {
                //var obj = response.json();
            //});
        },
        deleteProduct: function(index){
            _this.orderProductsDelete.push(this.order.products[index]);
            _this.order.products.splice(index, 1);
        },

        updateOrderValues: function(){
            _this.order.cost = 0;
            _this.order.price = 0;
            _this.order.total = 0;
            _this.order.overalldiscount = 0;

            for (var i = 0; i < this.order.products.length; i++) {
                var finalPrice = this.calcFinalPrice(_this.order.products[i]);
                _this.order.products[i].total = finalPrice.finalPrice;
                _this.order.products[i].discount = finalPrice.totalDiscount;

                _this.order.cost            += parseFloat(_this.order.products[i].cost);
                _this.order.price           += parseFloat(_this.order.products[i].price);
                _this.order.total           += parseFloat(_this.order.products[i].total);
                _this.order.overalldiscount += parseFloat(_this.order.products[i].discount);
            }
        },

        addToProductList: function(product){
            if(!_this.sarchByIdAndGrid(product)){
                var finalPrice = _this.calcFinalPrice(product);

                _this.order.products.push({
                    product_id:product.id,
                    code:product.code,
                    strLine:product.line.description,
                    strMaterial:product.material.description,
                    strColor:product.color.description,
                    cost:product.cost,
                    price:product.price,
                    chk_client_discount:false,
                    chk_representative_discount:false,
                    client_discount: product.client_discount,
                    representative_discount: product.representative_discount,
                    total: finalPrice.finalPrice,
                    discount:finalPrice.totalDiscount,
                    grid_id:product.grid_id,
                    strGrid: '',
                    qtd:product.qtd,
                });
                return _this.order.products[_this.order.products.length - 1];
            }else{
                toastr.warning('Atención', 'Producto ya se ha registrado para esta grid!');
            }
        },
        sarchByIdAndGrid: function(product){
            for (var i=0; i < _this.order.products.length; ++i) {
                var txt = _this.order.products[i].product_id + ' - ' +  _this.order.products[i].grid_id;
                if (_this.order.products[i].product_id == product.id &&
                        _this.order.products[i].grid_id == product.grid_id) {
                    return true;
                }
            }
            return false;
        },
        calcFinalPrice: function(product){
            var finalPrice              = {finalPrice:0, totalDiscount:0};
            var finalDiscount           = 0;
            var totalGeneralDiscount    = 0;
            var totalIndividualDiscount = 0;
            var qtd = product.qtd ? product.qtd : 1;

            totalGeneralDiscount    = _this.calcGeneralDiscount();
            totalIndividualDiscount = _this.calcIndidualDiscount(product);
            
            finalDiscount = totalIndividualDiscount? totalIndividualDiscount : totalGeneralDiscount;

            finalPrice.totalDiscount = ((parseFloat(finalDiscount)/100) * parseFloat(product.price));
            finalPrice.finalPrice = ((parseFloat(product.price) - parseFloat(finalPrice.totalDiscount)) * (qtd*12)) ;
            
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
        getDeliveryCenters: function(customer_id){
            this.$http.get('/api/deliverycenters/selectlist/'+customer_id)
                    .then(response => {
                _this.deliverycenters_select = response.json();
            });
        },

        submitData: function(){
            if(_this.validFields()){
                if(!_this.order.id)
                    _this.insertData();
                else
                    _this.updateData();
            }

        },
        validFields: function(){
            if(!_this.order.customer_id){
                toastr.warning('Atención', 'Elije el Cliente!');
                return false;
            }
            if(!_this.order.representative_id){
                toastr.warning('Atención', 'Elije el Representante!');
                return false;
            }
            if(!_this.order.delivery_id){
                toastr.warning('Atención', 'Elije el Cientro de Distribuición!');
                return false;
            }
            if(_this.order.products.length == 0){
                toastr.warning('Atencion!', 'Elije Productos para el Pedido!');
                return false;
            }
            return true;
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
        'order.products': function (val, oldVal) {
            _this.updateOrderValues();
        },
        'order.client_discount': function(val, oldVal){
            _this.updateOrderValues();
        },
        'order.representative_discount': function(val, oldVal){
            _this.updateOrderValues();
        },
        'order.customer_id':function(val, oldVal){
            if(val) _this.getDeliveryCenters(val);
        },
    },
}
</script>