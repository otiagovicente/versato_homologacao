<template>
    <div>
        <div class="row">
            <div class="md-col-12">
                <div class="col-md-12">
                    <div class="form-group form-line-input search">
                        <h4>Buscar</h4>
                        <div class="input-icon input-icon-lg right">
                            <i class="fa fa-search font-green"></i>
                            <input id="search-input" class="form-control input-lg" type="text" v-model="search">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 pull-right">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="md-col-12">
                <div class="col-md-12">
                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="form-control" v-model="entries" v-on:change="getOrders()">
                                <option>10</option>
                                <option>15</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group v-select">
                            <v-select
                                v-bind:options.sync="status_select" :value.sync="status_id"
                                placeholder="Status" class="form-control"
                                id="status-input" name="status"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group v-select">
                            <v-select
                                v-bind:options.sync="brands_select" :value.sync="brand_id"
                                placeholder="Marca" class="form-control"
                                id="brand-input" name="brand"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group v-select">
                            <v-select
                                v-bind:options.sync="macroregions_select" :value.sync="macroregion_id"
                                placeholder="Macro regiones" class="form-control"
                                id="macroregion-input" name="macroregion"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group v-select">
                            <v-select
                                v-bind:options.sync="regions_select" :value.sync="region_id"
                                placeholder="Regiones" class="form-control"
                                id="region-input" name="region"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group v-select">
                            <v-select
                                v-bind:options.sync="representatives_select" :value.sync="representative_id"
                                placeholder="Representante" class="form-control"
                                id="representative-input" name="representative"
                                search justified required close-on-select>
                            </v-select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="content-fluid" style="padding:20px;">
		<div class="row">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th><a v-on:click="setCampo('id')">Pedido</a></th>
                    <th><a>Representante</a></th>
                    <th><a>Cliente</a></th>
                    <th><a v-on:click="setCampo('cost')">Costo</a></th>
                    <th><a v-on:click="setCampo('price')">Precio</a></th>
                    <th><a v-on:click="setCampo('company_discount')">Desc.</a></th>
                    <th><a v-on:click="setCampo('representative_discount')">Desc. Representante</a></th>
                    <th><a v-on:click="setCampo('products_amount')">Qtd. Productos</a></th>
                    <th><a v-on:click="setCampo('total')">Total</a></th>
                    <th><a>Acciones</a></th>
                </tr>
                </thead>
                <tbody v-for="order in orders.data.data">
                    <tr>
                        <td>{{order.id}}</td>
                        <td>{{order.representative.user.name}}</td>
                        <td>{{order.customer.name}}</td>
                        <td>{{order.cost}}</td>
                        <td>{{order.price}}</td>
                        <td>{{order.company_discount}}</td>
                        <td>{{order.representative_discount}}</td>
                        <td>{{order.products_amount}}</td>
                        <td>{{order.total}}</td>
                        <td>
                            <a class="btn blue btn-outline sbold" v-on:click="goToOrder(order.id)">Editar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
              <ul class="pagination">
                <li><a v-on:click="setPage(page - 1)">Previous</a></li>
              </ul>
              <ul class="pagination" v-for="n in orders.data.last_page">
                  <li><a v-on:click="setPage(n+1)">{{ n+1 }}</a></li>
              </ul>
              <ul class="pagination">
              <li><a v-on:click="setPage(page + 1)">Next</a></li>
            </ul>
            </div>
        </div>
        <div class="hide form-excel">
            <form action='/orders/generate-sheet' method="post" class="hide">
                <input type="hidden" name="search" :value.sync="search"/>
                <input type="hidden" name="campo" :value.sync="campo"/>
                <input type="hidden" name="sequence" :value.sync="sequence"/>
                <input type="hidden" name="brand" :value.sync="brand_id"/>
                <input type="hidden" name="representative" :value.sync="representative_id"/>
                <input type="hidden" name="macroregion" :value.sync="macroregion_id"/>
                <input type="hidden" name="region" :value.sync="region_id"/>
                <input type="hidden" name="status_id" :value.sync="status_id"/>
                <input type="submit" />
            </form>
        </div>
    </div>
</template>

<style scoped>

    .search-box{
        width:100%;
        margin-bottom: 40px;
    }
    .list-customer-index-list-photo{

        width: 100%;

    }

    .list-customer-index-product-box{

        background-color: #FFFFFF;
        border: 3px solid #ebeef0;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 15px;
        text-align: center;



    }

</style>
<script type="text/babel">
    import VueStrap from 'vue-strap';
    
    export default{
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option
        },
        data(){
            return{
                brands_select:[],
                macroregions_select:[],
                regions_select:[],
                representatives_select:[],
                status_select: [
                    { value: 1, label: 'Abierto' },
                    { value: 2, label: 'Aprovado' },
                    { value: 3, label: 'Reprovado' },
                    { value: 4, label: 'Faturado' },
                    { value: 5, label: 'Enviado' },
                    { value: 6, label: 'Recebido' },
                ],/*
                <option value="1">Abierto</option>
                                <option value="2">Aprovado</option>
                                <option value="3">Reprovado</option>
                                <option value="4">Faturado</option>
                                <option value="5">Enviado</option>
                                <option value="6">Recebido</option>
                */
                orders: {
                    data: {
                      data: [],
                  },
                },
                search: '',
                entries: 10,
                page: 1,
                campo: 'id',
                sequence: 'asc',
                brand_id: null,
                macroregion_id: null,
                region_id: null,
                representative_id: null,
                status_id: null,
            }
        },
        watch: {
            'brand_id': function (val) {
                _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id);
            },
            'macroregion_id': function (val) {
                _listOrders.getRegions(val, doIt => _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id));
            },
            'region_id': function (val) {
                _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id);
            },
            'representative_id': function (val) {
                _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id);
            },
            'status_id': function (val) {
                _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id);
            },
            'search': function (val) {
                _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id);
            },
            'orders.data.last_page': function (val) {
               if(_listOrders.page > val){
                 _listOrders.setPage(val);
               }

            }
        },
        ready(){
            window._listOrders = this;
            _listOrders.getBrands();
            _listOrders.getMacroregions();
            //_listOrders.getRegions();
            _listOrders.getRepresentatives();
            _listOrders.getOrders();

            _listOrders.$parent.$on('fromRoot', () => _listOrders.methodMeiLoco());
        },
        methods:{
            methodMeiLoco: function() {
                /*var brand = _listOrders.brand_id || '';
                var representative = _listOrders.representative_id || '';
                var macroRegion = _listOrders.macroregion_id || '';
                var region = _listOrders.region_id || '';
                var _this = this;
                _this.$http.post('/api/orders/generate-sheet', {
                    campo : _listOrders.campo,
                    sequence : _listOrders.sequence,
                    brand : brand,
                    representative : representative,
                    macroregion : macroRegion,
                    region : region,
                    search :_listOrders.search
                })
                .then(response => {
                    _this.brands_select = response.json();
                });*/
                $('input[type="hidden"][name="_token"]').appendTo($('.form-excel form'));
                $('.form-excel form input[type=submit]').click();
            },
            getBrands: function(){
                var _this = this;
                _this.$http.get('/api/brands/selectlist')
                .then(response => {
                    _this.brands_select = response.json();
                });
            },
            getMacroregions: function(){
                var _this = this;
                _this.$http.get('/api/macroregions/selectlist')
                .then(response => {
                    _this.macroregions_select = response.json();
                });
            },
            getRegions: function(macroRegion, cb){
                var _this = this;

                if (!!_this.region_id)
                    _this.region_id = null;

                if (!macroRegion) {
                    _this.regions_select = [];
                    cb();
                    return;
                }

                _this.$http.get('/api/macroregions/'+macroRegion+'/regionsselectlist')
                .then(response => {
                    cb();
                    _this.regions_select = response.json();
                });
            },
            getRepresentatives: function(){
                var _this = this;
                _this.$http.get('/api/representatives/selectlistsimple')
                .then(response => {
                    _this.representatives_select = response.json();
                });
            },
            getOrders: function(brand, representative){
                var brand = brand || '';
                var representative = representative || '';
                var macroRegion = _listOrders.macroregion_id || '';
                var region = _listOrders.region_id || '';
                var status = _listOrders.status_id || '';

                this.$http.get('/api/orders/listIndex?page=' + _listOrders.page +
                '&entries=' + _listOrders.entries  +
                '&campo='+_listOrders.campo +
                '&sequence='+_listOrders.sequence +
                '&brand='+ brand +
                '&representative='+ representative +
                '&macroregion='+ macroRegion +
                '&region='+ region +
                '&status_id='+ status +
                '&search='+_listOrders.search)
                    .then((response) => {
                        console.log(JSON.parse(response.data));
                        _listOrders.orders.data = JSON.parse(response.data);

                    }).catch((response) => {
                        toastr.error('No fué posible conectar al servidor');
                    });
            },
            goToOrder(order_id){
              this.$http.post('/shopping-cart/stop-shopping');
              window.location.href = '/orders/'+order_id+'/edit';
            },
            setPage(n){
              if (n < 1){
                n = 1;
              }
              if (n > _listOrders.orders.data.last_page){
                n = _listOrders.orders.data.last_page;
              }
              
              _listOrders.page=n;
              _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id);
            },
            setCampo(cp){
              if (_listOrders.campo != cp){
                _listOrders.sequence = 'asc';
              }else{
                _listOrders.sequence = 'desc';
              }
              _listOrders.campo = cp;
              _listOrders.getOrders(_listOrders.brand_id, _listOrders.representative_id);
            }
        }
    }
</script>
