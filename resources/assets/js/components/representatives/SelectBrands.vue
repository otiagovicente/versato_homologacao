<template>
    <div>

        <div class="modal fade s" id="select-brands" tabindex="-1" role="select-brands" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">


                        <div class="portlet light" >
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-map-pin font-blue"></i>Marcas
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
                                    <div v-for="brand in brands | filterBy search" class="row">
                                        <div class="col-md-12 brand" v-bind:class="{ 'selected-brand': brand.selected }" >

                                            <img v-bind:src="brand.image" />

                                            <div class="form-group form-line-input comission" id="comission">
                                                <small>Comissión</small>
                                                <input class="form-control input-sm comission-input" type="number" v-model="brand.comission">
                                                <div class="select-button">
                                                    <button class="btn blue" @click="chooseBrand(brand)">Eligir</button>
                                                </div>

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
                    <div class="modal-footer">
                          <button class="btn blue" data-dismiss="modal">Cerrar</button>  
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style>
    .brand{

    }

    .comission{
        position: absolute;
        right: 50px;
        bottom: 30px;
    }
    .comission .comission-input{
        width: 50px;
    }
    .comission .select-button{
        width:70px;
    }
    .brand img{
        width:100%;
    }

    .selected-brand img{
        border-radius: 10px;
        border: 3px solid #3598DC;
    }


</style>
<script type="text/babel">
    export default{
        data(){
            return{
                search: '',
                brands: []
            }
        },
        ready(){
            window._SelectBrands = this;
            _SelectBrands.getBrands();

        },
        showSelectRegionModal: function () {

            $("#select-brands").on("shown.bs.modal", function (e) {

            });

            $("#select-brands").on("hide.bs.modal", function (e) {
                console.log(e);

                if(_SelectBrands.validateComission){
                    // $('#select-brands').modal('hide');
                }else{
                    // toastr.error('');
                }

            });
            return true;
        },
        computed:{
            selected_brands: function(){
                return _.filter(_SelectBrands.brands, function(brand) { return brand.selected; });
            },
            validateComission: function () {

                var selected_withoutcomission = _.filter(_SelectBrands.brands, function(brand){ return (brand.selected && brand.comission <= 0)});
                if(!selected_withoutcomission){
                    return true;
                }else{
                    return false;
                }
            }
        },
        methods:{
            /*
             * Funcões de Janela
             */

            openWindow: function (brands = null) {
                if(brands){
                    _SelectBrands.syncBrands(brands);
                }
                $('#select-brands').modal();
            },
            closeWindow: function () {

                if(_SelectBrands.validateComission){
                    $('#select-brands').modal('hide');
                }else{
                    toastr.error('');
                }


            },
            getBrands: function(){
                this.$http.get('/api/brands')
                        .then(response => {
                            _SelectBrands.brands = [];
                            _.forEach(response.json(), function(brand) {
                                brand.selected = false;
                                brand.comission = 0.00 ;
                                _SelectBrands.brands.push(brand);
                            });
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar las marcas - Select Brands');
                        });

            },
            chooseBrand: function (brand){

                if(brand.selected){
                    brand.selected = false;
                }
                else{
                    brand.selected = true;
                }

                _CreateRepresentative.brands = _SelectBrands.selected_brands;
            },
            syncBrands: function(brands){
                _.forEach(brands, function (brand) {
                    var index = _.findIndex(_SelectBrands.brands, function (item) {
                        return item.id == brand.id;
                    });
                    _SelectBrands.brands[index].selected = true;
                    _SelectBrands.brands[index].comission = brand.comission;
                });
            }


        }
    }
</script>
