<template>
    <div class="content-fluid" style="padding:20px;">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="/">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="/orders">Pedidos</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{getUrl()}}">Listar</a>
                </li>
            </ul>
            <div class="page-toolbar">
                <a href="/products"><button class="btn blue pull-right" style="margin-right:10px;">Adicionar Producto</button></a>

            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-md-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li>
                            <a aria-label="Previous" v-on:click="paginate(orders.prev_page_url)" v-show="orders.prev_page_url">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <li v-for="page in paginationLinks">
                            <a v-on:click="paginate(page.url)">{{ page.page }}1</a>
                        </li>

                        <li>
                            <a aria-label="Next" v-on:click="paginate(orders.next_page_url)" v-show="orders.next_page_url">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Representante</th>
                    <th>Cliente</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Desc. Cliente</th>
                    <th>Desc. Representante
                    <th>Qtd. Productos</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="order in orders.data">
                    <td>#{{ order.id}}</td>
                    <td>
                        {{order.representative.user.name}}
                    </td>
                    <td>
                        {{order.customer.name}}
                    </td>
                    <td>${{order.cost}}</td>
                    <td>${{order.price}}</td>
                    <td>{{order.client_discount}}</td>
                    <td>{{order.representative_discount}}</td>
                    <td>{{order.products.length}}</td>
                    <td>${{order.total}}</td>
                    <td>
                        <a class="btn blue btn-outline sbold"
                           data-toggle="modal"
                           href="#"
                           v-on:click="loadOrder(order.id)"
                        >
                            Editar
                        </a>

                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</template>
<style scoped>

</style>
<script type="text/babel">
    export default{
        data(){
            return{
                orders: {},
                url : '',
                paginationLinks : {}
            }
        },
        ready(){
            window._ListOrders = this;
            _ListOrders.getOrders();
        },
        methods : {
            getUrl(){
                return window.location.pathname;
            },
            loadOrder(order_id){
                this.$http.get('/shopping-cart/order/'+order_id)
                        .then(response => {
                            toastr.success('Cargo el pedido!');
                            window.location.href = "/orders/create";
                        }).catch(response => {
                            toastr.error('No fué possible cargar el pedido');
                        });
            },
            getOrders(){
                _ListOrders.url = '/api/orders';
                _ListOrders.paginate('/api/orders');
            },
            buildPaginationLinks(){
                var o = {};
                for (var i = 0; i < _ListOrders.last_page; i++) {
                    o.url = _ListOrders.url+'?page='+(i + 1);
                    o.page = (i+1);
                    _ListOrders.paginationLinks[i] = o;
                }


            },
            paginate(paginationUrl){

                this.$http.get(paginationUrl)
                        .then(response => {
                            _ListOrders.orders = response.json();
                            _ListOrders.buildPaginationLinks();
                        })
                        .catch(response => {
                            toastr.error('no fue possible cargar los pedidos');
                        });

            },
        }
    }
</script>
