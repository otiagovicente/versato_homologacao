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

                <div v-for="customer in customers | filterBy search">

                    <a @click="goToCustomer(customer.id)">
                        <div class="col-md-3">
                            <div class="list-customer-index-product-box">
                                <div class="row">

                                    <div class="col-md-12">
                                        <img class="list-customer-index-list-photo" v-bind:src="customer.logo" v-bind:alt="customer.name">
                                    </div>

                                </div>
                                <div class="row">
                                    <h3>{{customer.name}}</h3>
                                    <h5>{{customer.company}}</h5>
                                </div>
                            </div>

                        </div>
                    </a>

                </div>

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
                customers:[],
                search: ''
            }
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
            goToCustomer(customer_id){
                window.location.href = '/customers/'+customer_id;
            }
        }
    }
</script>
