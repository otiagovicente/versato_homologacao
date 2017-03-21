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

    export default{
        data(){
            return{
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
            }
        },
        watch: {
            'search': function (val) {
                _listOrders.getOrders();
            },
            'orders.data.last_page': function (val) {
               if(_listOrders.page > val){
                 _listOrders.setPage(val);
               }

            }
        },
        ready(){
            window._listOrders = this;
            _listOrders.getOrders();

        },
        methods:{
            getOrders: function(){
                this.$http.get('/api/orders/listIndex?page=' + _listOrders.page +
                '&entries=' + _listOrders.entries  +
                '&campo='+_listOrders.campo +
                '&sequence='+_listOrders.sequence +
                '&search='+_listOrders.search)
                    .then((response) => {

                        _listOrders.orders = response;

                    }).catch((response) => {
                        toastr.error('No fué posible conectar al servidor');
                    });
            },
            goToOrder(order_id){
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
              _listOrders.getOrders();
            },
            setCampo(cp){
              if (_listOrders.campo != cp){
                _listOrders.sequence = 'asc';
              }else{
                _listOrders.sequence = 'desc';
              }
              _listOrders.campo = cp;
              _listOrders.getOrders();
            }
        }
    }
</script>
