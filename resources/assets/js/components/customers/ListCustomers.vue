<template>

    <div class="grid js-masonry">

        <div v-for="customer in customers" class="grid-item">

            <div class="customer-box">

                <div class="customer-box-image">
                    <img v-bind:src="customer.logo">
                </div>

            </div>

        </div>

    </div>

</template>
<style>

    .customer-box {
        border-width: 1px;
        border-color: rgb(140, 199, 236);
        border-style: solid;
        border-radius: 10px;
        background-color: rgb(255, 255, 255);
        z-index: 2;
    }

    .customer-box-image{
        padding: 10px;
        width: 100%;
    }
    .customer-box-image img{
        max-width:250px;
    }


    .grid-sizer,
    .grid-item {
        max-width: 300px;
        min-width: 200px;
    }

    .grid-item-image{
        width: 100%;
    }


</style>
<script>

    export default{
        data(){
            return{
                customers:[]
            }
        },
        components:{
        },
        ready(){
            window._listCustomers = this;
            _listCustomers.configureMasonry();
            _listCustomers.getCustomers();
        },
        methods:{
            configureMasonry: function(){

                var $grid = $('.grid').masonry({
                    // options
                    itemSelector: '.grid-item',
                    columnWidth: '.grid-sizer',
                    percentPosition: true
                });

                // layout Masonry after each image loads
                $grid.imagesLoaded().progress( function() {
                    $grid.masonry('layout');
                });
            },
            getCustomers: function(){
                this.$http.get('/api/customers')
                    .then((response) => {

                        this.customers = response.json();

                    }).catch((response) => {
                        toastr.error('No fué posible conectar al servidor');
                    });
            }
        }
    }
</script>
