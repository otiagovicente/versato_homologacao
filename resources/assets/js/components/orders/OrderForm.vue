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
                        <div class="form-group form-line-input" id="customer_id">
                            <v-select 
                                v-bind:options.sync="customers_select" :value.sync="order.customer_id"
                                placeholder="Elije el cliente" class="form-control"
                                id="customer-input" name="customer[]"
                                search justified required close-on-select></v-select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Representante</small>
                        <div class="form-group form-line-input" id="customer_id">
                            <v-select 
                                v-bind:options.sync="representatives_select" :value.sync="order.representative_id"
                                placeholder="Elije el representante" class="form-control"
                                id="representative-input" name="representative[]"
                                search justified required close-on-select></v-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <small>Costo</small>
                        <div class="form-group form-line-input" id="cost">
                            <input 
                                id="code-input" 
                                class="form-control input-sm" 
                                type="number"
                                pattern="^\\$?(([1-9](\\d*|\\d{0,2}(,\\d{3})*))|0)(\\.\\d{1,2})?$" 
                                v-model="order.cost" 
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Precio</small>
                        <div class="form-group form-line-input" id="price">
                            <input 
                                contenteditable="false"
                                id="code-input" 
                                class="form-control input-sm" 
                                type="number"
                                pattern="^\\$?(([1-9](\\d*|\\d{0,2}(,\\d{3})*))|0)(\\.\\d{1,2})?$" 
                                v-model="order.price" 
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Descuento Promedio</small>
                        <div class="form-group form-line-input" id="overalldiscount">
                            <input 
                                contenteditable="false"
                                id="code-input" 
                                class="form-control input-sm" 
                                type="number"
                                v-model="order.overalldiscount" 
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
                                    <button class="btn blue" data-toggle="modal" 
                                    data-target=".bd-example-modal-lg">Adicionar Producto</button>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Costo</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="op in order.orderProducts">
                                    <td>{{op.code}}</td>
                                    <td>{{op.cost}}</td>
                                    <td>{{op.price}}</td>
                                    <td>{{op.discount}}</td>
                                    <td>{{op.total}}</td>
                                    <td>
                                        <button class="btn blue">Editar</button>
                                        <button class="btn grey">Excluir</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
                
                <hr/>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn grey">Cancelar</button>
                            <button class="btn blue" @click="submitData()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="row">
                    <div class="col-md-4">
                        <small>Marca</small>
                        <div class="form-group form-line-input" id="brand_id">
                            <v-select 
                                v-bind:options.sync="brands_select" :value.sync="brand_id"
                                placeholder="Elije la marca" class="form-control"
                                id="brand-input" name="brand[]"
                                search justified required close-on-select></v-select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="container-fluid product-list-row" v-for="p in products">
                        <div class="col-md-2">
                            <img class="product-list-photo" :src="p.photo" :alt="p.code">
                        </div>
                        <div class="col-md-offset-1 col-md-3">
                            <small>Código: {{p.code}}</small>
                        </div>
                        <div class="pull-right col-md-2">
                            <button 
                                class="btn btn-block blue"
                                @click="addToProductList(p)"
                                >
                                Selecionar
                            </button>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>

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
            order: {
                id:'',
                cost:0,
                price:0,
                overalldiscount:0,
                representative_comision:0,
                representative_discount:0,
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
        //if(this.pmacroregion) this.loadMacroregion(); 
    },
    methods:{
        addToProductList: function(product){
            this.order.orderProducts.push({
              id:product.id,
              code:product.code,
              cost:0,
              price:0,
            });
            return this.order.orderProducts[this.order.orderProducts.length - 1];
        },
        getBrands:function(brandid){
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
            //if(!this.macroregion.id)
            //  this.insertData();
            //else
            //  this.updateData();
        },
        
        insertData: function(){
          this.macroregion.geo = JSON.stringify(this.loadpolygon);
            this.$http.post('/macroregions', this.macroregion)
            .then((response) => {
              toastr.success('Sucesso!','Macro Região incluída com sucesso');
            }, (response) => { 
              this.showErrors(response.data); 
            }); 
        },
        
        updateData: function(){
          this.macroregion.geo = JSON.stringify(this.loadpolygon);
          this.$http.put('/macroregions/'+this.macroregion.id, this.macroregion)
          .then((response) => {
            toastr.success('Sucesso!','Macro Região atualizada com sucesso');
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
            if(this.brand_id)
                this.getProducts(this.brand_id);
        }
    }
}
</script>