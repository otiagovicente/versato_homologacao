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
        <div class="row">
            <div class="md-col-12">
                <div class="col-md-12">
                  <div class="col-md-2">
                    <div class="form-group">
                      <select class="form-control" v-model="entries" v-on:change="getCustomers()">
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select class="form-control" v-model="cp" v-on:change="setCampo(cp)">
                        <option>name</option>
                        <option>company</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <hr>
        <div class="container-fluid">
            <div class="row">

                <div v-for="customer in customers.data.data">

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
            <div class="row">
              <ul class="pagination">
                <li><a v-on:click="setPage(page - 1)">Previous</a></li>
              </ul>
              <ul class="pagination" v-for="n in customers.data.last_page">
                  <li><a v-on:click="setPage(n+1)">{{ n+1 }}</a></li>
              </ul>
              <ul class="pagination">
              <li><a v-on:click="setPage(page + 1)">Next</a></li>
            </ul>
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
                customers: {
                  data: {
                    data: [],
                  },
                },
                search: '',
                entries: 10,
                page: 1,
                campo: 'id',
                cp: '',
                sequence: 'asc',
            }
        },
        watch: {
            'search': function (val) {
                _listCustomers.getCustomers();
            },
            'customers.data.last_page': function (val) {
               if(_listCustomers.page > val){
                 _listCustomers.setPage(val);
               }

            }
        },
        ready(){
            window._listCustomers = this;
            _listCustomers.getCustomers();

        },
        methods:{
            getCustomers: function(){
                this.$http.get('/api/customers?page=' + _listCustomers.page +
                '&entries=' + _listCustomers.entries +
                '&campo='+_listCustomers.campo +
                '&sequence='+_listCustomers.sequence +
                '&search='+_listCustomers.search)
                    .then((response) => {

                        this.customers = response;

                    }).catch((response) => {
                        toastr.error('No fué posible conectar al servidor');
                    });
            },
            goToCustomer(customer_id){
                window.location.href = '/customers/'+customer_id;
            },
            setPage(n){
              if (n < 1){
                n = 1;
              }
              if (n > _listCustomers.customers.data.last_page){
                n = _listCustomers.customers.data.last_page;
              }
              _listCustomers.page=n;
              this.getCustomers();
            },
            setCampo(cp){
              if (_listCustomers.campo != cp){
                _listCustomers.sequence = 'asc';
              }else{
                _listCustomers.sequence = 'desc';
              }
              _listCustomers.campo = cp;
              _listCustomers.getCustomers();
            }
        }
    }
</script>
