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
        <hr>
        <div class="container-fluid">
            <div class="row">

                <div v-for="product in products | filterBy search">

                    <a @click="goToProduct(product.id)">
                        <div class="col-md-3">
                            <div class="list-product-index-product-box">
                                <div class="row">

                                    <div class="col-md-12">
                                        <img class="list-product-index-list-photo" v-bind:src="product.photo" alt="{{product.code}}">
                                    </div>

                                </div>
                                <div class="row">
                                    <h4>{{product.line.description+' '+product.material.description}}</h4>
                                    <h5>{{product.color.description}}</h5>
                                </div>
                            </div>

                        </div>
                    </a>

                </div>

            </div>
        </div>

    </div>
</template>
<style>
    .list-product-index-list-photo{

        width: 100%;

    }

    .list-product-index-product-box{

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
            return {
                search: '',
                products: []
            }
        },
        props: ['id', 'type'],
        ready(){
            window._ListProducts = this;
            _ListProducts.getProducts();

        },
        methods: {

            getProducts(){

                console.log(_ListProducts.type);
                switch (_ListProducts.type) {
                    case 'line':
                        _ListProducts.getProductsByLine();
                        break;
                    case 'material':
                        _ListProducts.getProductsByMaterial();
                        break;
                    case 'color':
                        _ListProducts.getProductsByColors();
                        break;
                }
            },

            getProductsByLine(){

                this.$http.get('/api/lines/' + _ListProducts.id + '/products')
                        .then(response => {
                            _ListProducts.products = response.json();
                        })
                        .catch(response => {
                            toastr.error('no se puede cargar los productos por las colores');
                        });
            },
            getProductsByMaterial(){

                this.$http.get('/api/materials/' + _ListProducts.id + '/products')
                        .then(response => {
                            _ListProducts.products = response.json();
                        })
                        .catch(response => {
                            toastr.error('no se puede cargar los productos por las colores');
                        });
            },
            getProductsByColors(){

                this.$http.get('/api/colors/' + _ListProducts.id + '/products')
                        .then(response => {
                            _ListProducts.products = response.json();
                        })
                        .catch(response => {
                            toastr.error('no se puede cargar los productos por las colores');
                        });
            },

            /*
             *  Actions de Links
             */
            goToProduct(id){

                window.location.href="/products/"+id;

            }


        }
    }
</script>
