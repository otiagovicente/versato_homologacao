<template>

    <div class="md-col-12">
        <div class="row">
                <div class="form-group form-line-input search">
                    <h4>Buscar</h4>
                    <div class="input-icon input-icon-lg right">
                        <i class="fa fa-search font-green"></i>
                        <input id="search-input" class="form-control input-lg" type="text" name="search" v-model="query" v-on:keyup.enter="search()">
                    </div>
                </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li>
                            <a aria-label="Previous" v-on:click="paginate(pagination.prev_page_url)" v-show="pagination.prev_page_url">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <li v-for="page in paginationLinks">
                            <a v-on:click="paginate(page.url)">{{ page.page }}</a>
                        </li>

                        <li>
                            <a aria-label="Next" v-on:click="paginate(pagination.next_page_url)" v-show="pagination.next_page_url">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="innerProduct" v-for="product in products">
            <a v-on:click="goToProduct(product.id)">
                <div class="col-md-3 innerInnerProduct">
                    <div class="product-index-product-box">
                        <div class="row">

                            <div class="col-md-12 innerImage">
                                <img class="product-index-list-photo" v-bind:src="product.photo" v-bind:alt="product.code">
                            </div>
                        </div>
                        <div class="row">
                            <h4>{{product.line.description}} {{product.material.description}}</h4>
                            <h5>{{product.color.description}}</h5>
                        </div>
                    </div>
                    <a v-on:click="addProduct(product.id)" class="addToCart">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </a>
        </div>
    </div>
    <add-product-to-order></add-product-to-order>

</template>
<style scoped>
        .product-index-list-photo{

            width: 100%;

        }

        .product-index-product-box{

            background-color: #FFFFFF;
            border: 3px solid #ebeef0;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            text-align: center;



        }

        .innerProduct {
            height: 250px;
            width: 20%;
            position: relative;
            float: left;
        } .innerProduct img  {
            float: left;
                  width: 100%;
                      height:auto;
                  }
        .innerImage {
            width:100%;
        }
        .product-index-product-box {
            float: left;
            width:100%;
        } .innerProduct a, .innerInnerProduct {
                      width: 100%;
                      float: left;
                  }

          .addToCart {
              width: 30px !important;
              height: 30px !important;
              line-height:25px;
              text-align: center;
              position: absolute;
              right: 0px;
              top:0px;

              background-color: #FFFFFF;
              border: 3px solid #ebeef0;
              border-radius: 50%;

              color: green;
          }

        @media only screen and (max-width: 1000px) {
            .innerProduct {
                width:100%;
                height:auto;
            }

            .addToCart {
                width:80px !important;
                height:80px !important;
                font-size:45px;
                line-height:70px;
            }
        }

</style>
<script type="text/babel">

    import AddProductToOrder from './AddProductToOrder.vue'

    export default{
        data(){
            return {
                query: '',
                url : '',
                products: {},
                pagination : {},
                paginationLinks : [],
            }
        },
        components:{
            'add-product-to-order': AddProductToOrder,
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
                    default:
                        _ListProducts.getAllProducts();
                }


            },

            getAllProducts(){
                _ListProducts.url = '/api/brands/' + Versato.brand_id + '/products' ;
                _ListProducts.paginate(_ListProducts.url);

            },
            getProductsByLine(){

                _ListProducts.url = '/api/lines/' + _ListProducts.id + '/products';
                _ListProducts.paginate(_ListProducts.url);
            },
            getProductsByMaterial(){
                _ListProducts.url = '/api/materials/' + _ListProducts.id + '/products';
                _ListProducts.paginate(_ListProducts.url);
            },
            getProductsByColors(){

                _ListProducts.url = '/api/colors/' + _ListProducts.id + '/products';
                _ListProducts.paginate(_ListProducts.url);
            },

            /*
             *  Actions de Links
             */
            goToProduct(id){

                window.location.href="/products/"+id;

            },
            buildPaginationLinks(){
                var o = {};
                
                for (var i = 0; i < _ListProducts.pagination.last_page; i++) {
                    var o = {};
                    o.url = _ListProducts.url+'?page='+(i + 1);
                    o.page = (i+1);
                    this.paginationLinks.push(o);
                }
            },
            paginate(paginationUrl){

                this.$http.get(paginationUrl)
                        .then(response => {
                            _ListProducts.pagination = response.json();
                            _ListProducts.pagination.data = null;
                            _ListProducts.products = response.json().data;
                            _ListProducts.buildPaginationLinks();
                        })
                        .catch(response => {
                            toastr.error('no fue possible cargar los productos');
                        });

            },
            search(){
                _ListProducts.url = '/api/products/search/' +  Versato.brand_id + '?search='+_ListProducts.query;
                _ListProducts.paginate(_ListProducts.url);
            },
            addProduct(product_id){
                _AddProductToOrder.openWindow(product_id);
            }


        }
    }
</script>
