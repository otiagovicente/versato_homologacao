<template>
        <li class="dropdown dropdown-extended dropdown-tasks" id="header_order_bar">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-shopping-cart"></i>
                <span class="badge badge-default">
                    {{ amount }} </span>
            </a>
            <ul class="dropdown-menu extended tasks">
                <li>
                    <h4>
                        Pedido
                    </h4>
                </li>
                <li>
                    <ul class="dropdown-menu-list scroller" style="height: 250px;">
                        <li v-for="product in order.products" class="order-header-bar-product-box">
                            <a href="#">
                                <img v-bind:src="product.photo" />
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="external">
                    <a href="/orders/create">
                        Ver Pedido <i class="m-icon-swapright"></i>
                    </a>
                </li>
            </ul>
        </li>

</template>
<style scoped>
    .order-header-bar-product-box{

        height: 80px;
        width: 100%;

    }
    .order-header-bar-product-box h4{
        padding-left: 10px;
        left: 10px;
    }

    .order-header-bar-product-box img{
        height: 50px;
        width: auto;
    }
</style>
<script type="text/babel">
    export default{
        data(){
            return{
                order: {
                    products:{}
                }
            }
        },
        computed: {
            // a computed getter
            amount: function () {
                // `this` points to the vm instance
                if(this.order.products){
                    return this.order.products.length;
                }
                return 0;
            }
        },
        ready(){
            window._OrderHeaderBar = this;
            _OrderHeaderBar.getOrder();
            _OrderHeaderBar.$parent.$on('addProduct', () => _OrderHeaderBar.getOrder());
        },
        methods:{
            getOrder(){
                this.$http.get('/shopping-cart/get-order')
                        .then(response => {
                            _OrderHeaderBar.order = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fué posible cargar el pedido');
                        });
            }
        }
    }
</script>
