<template>

    <div>

        <div class="search-box">
                <div class="input-icon input-icon-lg right">
                    <i class="fa fa-search font-green"></i>
                    <input id="search-input" class="form-control input-lg" type="text" v-model="search" />
                </div>
        </div>

                <div class="clearfix"></div>
                <div class="grid">
                    <div v-for="customer in customers | filterBy search">

                        <div class="grid-item" @click="showCustomer(customer.id)">

                            <div class="customer-box">

                                <div class="customer-box-image">
                                    <img v-bind:src="customer.logo" class="img-rounded">
                                </div>

                                <div class="clearfix"></div>
                                <br>
                                <span>{{customer.name}}</span><br>
                                <span>{{ customer.company}}</span>

                            </div>

                        </div>


                    </div>
                </div>

    </div>

</template>
<style>

    .search-box{
        width:100%;
        margin-bottom: 40px;
    }
    .customer-box {
        border-width: 1px;
        border-color: rgb(140, 199, 236);
        border-style: solid;
        border-radius: 8px;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .customer-box-image{
        width: 100%;
    }
    .customer-box-image img{
        width:100%;
    }
    .grid-item {
      border: 2px solid hsla(0, 0%, 0%, 0.5);
      max-width:200px;
    }

    .grid-item--width2 { width: 160px; }
    .grid-item--height2 { height: 140px; }


</style>
<script type="text/babel">

    export default{
        data(){
            return{
                customers:[],
                search: ''
            }
        },
        components:{
        },
        watch:{

            'search': function () {
                _listCustomers.$grid.masonry('reloadItems');
                _listCustomers.$grid.masonry('layout');
                console.log('items rearrenged');
            }

        },
        ready(){
            window._listCustomers = this;
            _listCustomers.getCustomers();
            _listCustomers.layout();

        },
        methods:{
            getCustomers: function(){
                this.$http.get('/api/customers')
                    .then((response) => {

                        this.customers = response.json();

                    }).catch((response) => {
                        toastr.error('No fué posible conectar al servidor');
                    });
            },
            showCustomer: function(customer_id){
                window.location.href = '/customers/'+customer_id;
            },
            layout: function () {
                _listCustomers.$grid = $('.grid').imagesLoaded( function() {
                    // init Masonry after all images have loaded
                    _listCustomers.$grid.masonry({
                        itemSelector: '.grid-item',
                        fitWidth: true,
                        gutter:10,
                        percentPosition: true
                    });
                    _listCustomers.$grid.masonry('layout');
                });
            }
        }
    }
</script>
