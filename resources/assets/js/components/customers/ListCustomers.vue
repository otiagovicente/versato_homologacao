<template>

    <div class="container-fluid">

        <div class="row search-box">
            <div class="col-lg-12">
                <div class="input-icon input-icon-lg right">
                    <i class="fa fa-search font-green"></i>
                    <input id="search-input" class="form-control input-lg" type="text" v-model="search" />
                </div>
            </div>
        </div>
        <div class="row">
            <div v-for="customer in customers | filterBy search" class="col-md-3">

                <div class="customer-box">

                    <div class="customer-box-image" @click="showCustomer(customer.id)">
                            <img v-bind:src="customer.logo" class="img-rounded">
                    </div>

                </div>

            </div>
        </div>
    </div>

</template>
<style>

    .search-box{
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
        margin-bottom: 15px;
        cursor: pointer;
    }

    .customer-box-image{
        width: 100%;
    }
    .customer-box-image img{
        max-width:250px;
    }

</style>
<script>

    export default{
        data(){
            return{
                customers:[],
                search: ''
            }
        },
        components:{
        },
        ready(){
            window._listCustomers = this;
            _listCustomers.getCustomers();
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
            }
        }
    }
</script>
