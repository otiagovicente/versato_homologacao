<template>
        <div class="portlet light" >
            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-truck font-blue"></i>Centros de Entrega
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
                <div style="height:500px; overflow-y: scroll;">
                    <div v-for="deliverycenter in deliverycenters | filterBy search" class="row">
                        <div class="col-md-12" @click="editDeliveryCenter(deliverycenter.id)">
                                <span class="caption font-blue"> {{deliverycenter.name}} </span>
                                <br>
                                <span class="caption font-blue"> {{deliverycenter.address}} </span>
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
    .deliverycenter-logo{

        width:100%;
    }
</style>
<script type="text/babel">
    export default{
        data(){
            return{
                search : '',
                deliverycenters: []
            }
        },
        props: ['pcustomer_id'],
        events:{
            MapsApiLoaded: function () {
                return true;
            },
            DeliveryCenterCreated: function(){
                console.log('DeliveryCenterCreated');
                _listDeliveryCenter.reloadDeliveryCenters();
            },
            DeliveryCenterUpdated: function(){
                console.log('DeliveryCenterUpdated');
                _listDeliveryCenter.reloadDeliveryCenters();
            }
        },
        ready(){
            window._listDeliveryCenter = this;
            _listDeliveryCenter.getDeliveryCenters();

        },
        methods:{
            getDeliveryCenters: function(){
                this.$http.get('/api/customers/'+_listDeliveryCenter.pcustomer_id+'/deliverycenters')
                .then( response => {
                    _listDeliveryCenter.deliverycenters = response.json();
                }).catch(response=>{
                    toastr.error('No se puede cargar los centros de entrega');
                });
            },
            reloadDeliveryCenters: function(){
                _listDeliveryCenter.getDeliveryCenters();
            },
            editDeliveryCenter(deliveryCenterId){
                _CreateDeliveryCenter.openWindow(deliveryCenterId);
            }

        }
    }
</script>
