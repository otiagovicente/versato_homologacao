<template>

    <div class="grid js-masonry">

        <div class="static-banner">Static banner</div>

        <div class="grid-item">
            <div class="col-md-6">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption font-blue">
                            <i class="fa fa-map-pin font-blue"></i>Tiendas
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div v-for="shop in shops" class="row">

                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <img v-if="shop.logo" class="shop-logo" v-bind:src="shop.logo" />
                                    <img v-else class="shop-logo" v-bind:src="customer.logo" />
                                </div>
                                <div class="col-md-8" style="padding-top:5px;">
                                    <span class="caption font-blue"> {{shop.name}} </span>
                                    <br>
                                    <span class="caption font-blue"> {{shop.address}} </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="grid-item">
            <img class="grid-item-image" src="https://s3-sa-east-1.amazonaws.com/sistema-versato/customers/ae4bf7c5d28894e534fa4b3ee5c0e084.jpeg"/>
        </div>

        <div class="grid-item">
            <img class="grid-item-image" src="https://s3-sa-east-1.amazonaws.com/sistema-versato/customers/ae4bf7c5d28894e534fa4b3ee5c0e084.jpeg"/>
        </div>

        <div class="grid-item">
            <img class="grid-item-image" src="https://s3-sa-east-1.amazonaws.com/sistema-versato/customers/ae4bf7c5d28894e534fa4b3ee5c0e084.jpeg"/>
        </div>

        <div class="grid-item">
            <img class="grid-item-image" src="https://s3-sa-east-1.amazonaws.com/sistema-versato/customers/ae4bf7c5d28894e534fa4b3ee5c0e084.jpeg"/>
        </div>



    </div>

</template>
<style>

    .grid-item-image{
        width: 200px;
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
        },
        ready(){
            window._listCustomers = this;
            _listCustomers.configureMasonry();
        },
        methods:{
            configureMasonry: function(){

                var $grid = $('.grid').masonry({
                    // options
                    itemSelector: '.grid-item',
                    columnWidth: 200
                });
                // layout Masonry after each image loads
                $grid.imagesLoaded().progress( function() {
                    $grid.masonry('layout');
                });
            }
        }
    }
</script>
