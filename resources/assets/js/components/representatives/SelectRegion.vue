<template>
    <div>
        <div class="modal fade" id="select-region" tabindex="-1" role="create-shop" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">


                        <div class="portlet light" >
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-map-pin font-blue"></i>Regiones
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <small>Macro Regiones</small>
                                        <div class="form-group form-line-input" id="macroregions">
                                            <v-select
                                                    v-bind:options.sync="macroregions_select"
                                                    :value.sync="macroregion"
                                                    placeholder="Elije la macro región"
                                                    id="macroregions-input"
                                                    name="macroregions[]"
                                                    search justified required close-on-select
                                                    style="width:100%;"
                                            ></v-select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row search-box">
                                    <div class="col-lg-12">
                                        <div class="input-icon input-icon-sm right">
                                            <i class="fa fa-search font-green"></i>
                                            <input id="search-input" class="form-control input-sm" type="text" v-model="search" />
                                        </div>
                                    </div>
                                </div>
                                <div style="height:400px; overflow-y: scroll;">
                                    <div v-for="region in regions | filterBy search" class="row">
                                        <div class="col-md-12 ">
                                            <div class="region-box col-md-12" style="padding-top:5px;" v-bind:class="{ 'selected': region.selected }" @click="chooseRegion(region)">
                                                    <h3 > <strong>{{region.description}} </strong></h3>
                                                    <span> {{region.code}} </span>
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
                </div>
            </div>
        </div>
    </div>
</template>
<style>

    .region-box{

        height: 125px;
        position: relative;
        cursor:pointer;
        border-radius: 15px;
        border: 1px solid #3598DC;
        margin-bottom: 10px;
        padding: 15px;

    }
    .selected{
        background-color:#578EBE;
        color: #FFF;
        font-weight: bold;
    }
</style>
<script type="text/babel">
    import VueStrap from 'vue-strap'
    export default{
        components:{
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
        },
        data(){
            return{
                search: '',
                macroregions_select: new Array(),
                macroregion : null,
                regions: new Array()
            }
        },
        showSelectRegionModal: function () {

            $("#select-region").on("shown.bs.modal", function (e) {

            });

            $("#select-region").on("hidden.bs.modal", function (e) {

            });
            return true;
        },
        ready(){
            window._SelectRegion = this;
            _SelectRegion.getMacroRegions();
        },
        computed:{
            selected_regions: function(){
                return _.filter(_SelectRegion.regions, function(region) { return region.selected; });
            }
        },
        watch:{
            'macroregion': function () {
                _SelectRegion.getRegions(_SelectRegion.macroregion);
            }
        },
        methods:{

            getMacroRegions: function(){
                this.$http.get('/api/macroregions/selectlist')
                        .then(response => {
                            this.macroregions_select = response.json();
                        });
            },
            getRegions: function(regionid){
                this.$http.get('/api/macroregions/'+regionid+'/regions')
                        .then(response=>{
                            _SelectRegion.regions = [];
                            _.forEach(response.json(), function(region) {
                                region.selected = false;
                                _SelectRegion.regions.push(region);
                            });
                        })
                        .catch(response=>{
                            toastr.error('No fue possible cargar las regiones');
                        });
            },
            chooseRegion: function(region){

                if(region.selected){
                    region.selected = false;
                }
                else{
                    region.selected = true;
                }

                _CreateRepresentative.regions = _SelectRegion.selected_regions;
            },
            /*
             * Funcões de Janela
             */

            openWindow: function () {
                $('#select-region').modal();

            },
            closeWindow: function () {
                $('#select-region').modal('hide');
            },
            reload: function () {

            },
        }
    }
</script>
