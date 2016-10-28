<template>
    <div class="portlet light" >
        <div class="portlet-title">
            <div class="caption font-blue">
                <i class="fa fa-map-pin font-blue"></i>Tiendas
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row search-box">
                <div class="col-lg-12">
                    <div class="input-icon input-icon-sm right">
                        <i class="fa fa-search font-green"></i>
                        <input id="search-input" class="form-control input-sm" type="text" v-model="search" />
                    </div>
                </div>
            </div>
            <div style="height:400px; overflow-y: scroll;">
                <div v-for="shop in shops | filterBy search" class="row">
                    <div class="col-md-12" @click="editShop(shop.id)">
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
</template>
<style>
    .shop-logo{
        width:100%;
    }
</style>
<script type="text/babel">
    export default{
        data(){
            return{
                search : '',
                shops: [],
                customer: []
            }
        },
        props: ['pcustomer_id'],
        events:{
            MapsApiLoaded: function () {
                return true;
            },
            shopCreated: function(){
                console.log('shop created');
                _ListShops.reloadShops();
            },
            shopUpdated: function(){
                console.log('shop updated');
                _ListShops.reloadShops();
            }
        },
        ready(){
            window._ListShops = this;
            _ListShops.getShops();
            this.loadCustomer();

        },
        methods:{
            loadCustomer: function(){
                this.$http.get('/api/customers/' + _ListShops.pcustomer_id)
                        .then((response)=> {
                            _ListShops.customer = response.json();

                        }).catch((response)=> {
                    toastr.error('No se puede conectar al servidor. getCustomer Fails');
                });
            },
            getShops: function(){
                this.$http.get('/api/customers/'+_ListShops.pcustomer_id+'/shops')
                        .then( response => {
                            _ListShops.shops = response.json();
                            // console.log(response.json());
                            // _ListShops.shops = [];
                            //
                            // $.each(response.json(), function (index) {
                            //     this.geo = JSON.parse(this.geo);
                            //     _ListShops.shops.push(this);
                            // });


                        }).catch(response=>{
                    toastr.error('No se puede cargar las tiendas');
                });
            },
            reloadShops: function () {
                _ListShops.getShops();
            },
            editShop: function (shopId) {
                _shopForm.openWindow(shopId);
            }

        },

    }
</script>
