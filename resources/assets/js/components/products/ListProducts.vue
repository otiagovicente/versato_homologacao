<template>
    <div>

        <div class="md-col-12">
            <div class="col-md-7">
                <div class="form-group form-line-input search">
                    <h4>Buscar</h4>
                    <div class="input-icon input-icon-lg right">
                        <i class="fa fa-search font-green"></i>
                        <input id="search-input" class="form-control input-lg" type="text">
                    </div>
                </div>
            </div>
            <div class="col-md-5 pull-right">
               links de paginação
            </div>
        </div>
        <hr>
        <div class="container-fluid">
            <div class="row">

                @foreach($products as $product)
                <a href="/products/{{product.id}}">
                    <div class="col-md-3">
                        <div class="product-index-product-box">
                            <div class="row">

                                <div class="col-md-12">
                                    <img class="product-index-list-photo" src="{{product.photo}}" alt="{{product.code}}">
                                </div>

                            </div>
                            <div class="row">
                                <h4>{{product.line.description+' '+product.material.description}}</h4>
                                <h5>{{product.color.description}}</h5>
                            </div>
                        </div>



                    </div>
                </a>

                @endforeach
            </div>
        </div>

    </div>
</template>
<style>
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
</style>
<script>
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        components:{
        }
    }
</script>
