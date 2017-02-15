<template>
    <div>

        <div class="modal fade" id="select-brands" tabindex="-1" role="select-brands" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h3 class="font-blue uppercase">Marcas</h3>
                    </div>
                    <div class="modal-body">

                        <div style="height:400px; overflow-y: scroll;">
                            <div v-for="brand in brands" class="brand"
                                 v-bind:class="{ 'selected-brand': brand.selected }"
                                 @click="chooseBrand(brand)">
                                <span class="brand-name">{{ brand.name }}</span>
                                <span class="check"><i class="fa fa-check"></i></span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>
<style>

    .brand{
        width:100%;
        height: 100px;
        position: relative;
        color: #000;
        display : flex;
        align-items : center;
        justify-content : space-between;
        margin-bottom: 15px;
        cursor : pointer;
        padding : 20px 10px 20px 10px;
        transition:all 0.5s ease;

    }

    .brand .brand-name {
        font-family : Roboto, sans-serif;
        font-weight: 200;
        font-size: 26px;
    }

    .brand:hover .brand-name{
        color : #3598dc;
    }
    .brand:active .brand-name{
        color : #4276A4;
    }

    .brand .check{
        color : #eaeaea;
        font-size: 26px;
    }
    .brand:active .check{
        color: #4276A4;
    }
    .selected-brand .check{
        color : #3598dc;
    }








</style>
<script type="text/babel">
    export default{
        data(){
            return {
                search: '',
                brands: {}
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

                if (_SelectBrands.validateComission) {
                    // $('#select-brands').modal('hide');
                } else {
                    // toastr.error('');
                }

            });
            return true;
        },
        computed: {
            selected_brands: function () {
                return _.filter(_SelectBrands.brands, function (brand) {
                    return brand.selected;
                });
            }
        },
        methods: {
            /*
             * Funcões de Janela
             */

            openWindow: function (brands = null) {
                if (brands) {
                    _SelectBrands.syncBrands(brands);
                }
                $('#select-brands').modal();
            },
            closeWindow: function () {

                if (_SelectBrands.validateComission) {
                    $('#select-brands').modal('hide');
                } else {
                    toastr.error('');
                }


            },
            getBrands: function () {
                this.$http.get('/api/brands')
                        .then(response => {
                            _SelectBrands.brands = [];
                            _.forEach(response.json(), function (brand) {
                                brand.selected = false;
                                brand.comission = 0.00;
                                _SelectBrands.brands.push(brand);
                            });
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar las marcas - Select Brands');
                        });

            },
            chooseBrand: function (brand) {

                if (brand.selected) {

                    brand.selected = false;

                }
                else {
                    brand.selected = true;
                }

                _CreateRepresentative.brands = _SelectBrands.selected_brands;
            },

            syncBrands: function (brands) {
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
