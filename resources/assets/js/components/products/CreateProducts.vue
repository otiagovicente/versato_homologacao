<style scoped>
    .dropzone {
        min-height: 150px;
        border: 2px dashed #eaeaea;
        background: white;
        padding: 20px 20px;
    }

</style>
<template>
    <div class="content">
        <div class="portlet light">

            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus font-blue"></i>Criar Produto
                </div>
            </div>

            <div class="portlet-body form">
                <form id="form-product">
                    <input type="hidden" v-model="product.brand_id" name="brand_id">

                    <div class="row">
                        <div class="col-md-4">
                            <h3>Código:</h3>
                            <span class="h4" id="line-code">{{ product.line_code }}</span>
                            <span class="h4"  id="reference-code">{{ product.reference_code }}</span>
                            <span class="h4"  id="material-code">{{ product.material_code }}</span>
                            <span class="h4"  id="color-code">{{ product.color_code }}</span>
                            <input v-model="product.code" type="hidden" name="code" value="" id="code">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <small>Imagem</small>
                            <div id="photo-input" class="form-group">
                                <div class="">
                                    <img id="photo-image"  v-bind:src="product.photo" class="figure-img img-fluid img-rounded" alt="sem imagem do produto." style="width:200px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="photo" class="dropzone">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="form-group form-line-input" id="line-input">
                                <small>Línea</small>

                                <input id="line" data-provide="typeahead" class="typeahead form-control input-sm" type="text"
                                       v-model="linesQuery"
                                       v-on:keyup.enter="searchLines"
                                       debounce="500">

                            </div>
                            <div class="form-group form-line-input " id="reference-input">

                                <small>Modelo</small>
                                <input id="reference" data-provide="typeahead" class="typeahead form-control input-sm" type="text"
                                       v-model="referencesQuery"
                                       v-on:keyup.enter="searchReferences"
                                       debounce="500">
                            </div>
                            <div class="form-group form-line-input " id="material-input">
                                <small>Material</small>
                                <input id="material" data-provide="typeahead" class="typeahead form-control input-sm" type="text"
                                       v-model="materialsQuery"
                                       v-on:keyup.enter="searchMaterials"
                                       debounce="500">
                            </div>
                            <div class="form-group form-line-input" id="color-input">
                                <small>Color</small>
                                <input id="color" class="typeahead form-control input-sm" type="text"
                                       v-model="colorsQuery"
                                       v-on:keyup.enter="searchColors"
                                       debounce="500">

                            </div>
                            <div class="form-group form-line-input" id="launch-input">
                                <small>Lançamento</small><br>
                                <!--<datepicker :value.sync="product.launch" format="dd/MM/yyyy" width="280px">-->
                                <!--</datepicker>-->
                            </div>
                            <div class="form-group form-line-input" id="published-input">
                                <small>Publicado?</small><br>
                                <input type="checkbox" name="published" v-model="product.published">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-line-input">
                                <small>Costo</small>
                                <input name="cost" type="text" v-model="product.cost | currencyDisplay" class="form-control" id="cost-input">

                            </div>
                            <div class="form-group form-line-input">
                                <small>Precio</small>
                                <input name="price" type="text" v-model="product.price | currencyDisplay" class="form-control" id="price-input">
                            </div>
                            <div class="form-group form-line-input">
                                <small>Tareas</small>
                                <!--<v-select url="/api/tags/selectlist/1" :value.sync="product.grids" placeholder="Elije as grades"  multiple class="form-control" id="grids-input" name="grids[]" search justified required close-on-select></v-select>-->
                            </div>
                            <div class="form-group form-line-input">
                                <small>Tags</small>
                                <!--<v-select url="/api/tags/selectlist/1" :value.sync="product.tags"  placeholder="Elije as tags" multiple class="form-control" id="grids-input" name="grids[]" search justified required close-on-select></v-select>-->

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <div class="container-fluid">
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <button type="button" @click="submitData()" class="btn blue btn-block" id="send-btn">Salvar</button>
                                </div>
                            </div>
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <a href="/products/"><button type="button" class="btn grey btn-block" id="send-btn">Cancel</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import VueStrap from 'vue-strap'
    import VueTypeahead from 'vue-typeahead'
    import AlgoliaSearch from 'algoliasearch'
    import moment from 'moment'
    import FileUpload from 'vue-upload-component'

    export default{
        extends: VueTypeahead,
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker,
        },
        data(){
            return{
                product: {
                    code: '',
                    line_id: '',
                    line_code: '',
                    reference_id: '',
                    reference_code: '',
                    material_id: '',
                    material_code: '',
                    color_id: '',
                    color_code: '',
                    cost: 0.00,
                    price: 0.00,
                    grids: [],
                    photo: '/images/default-placeholder.jpg',
                    brand_id: '',
                    launch: moment().format('DD/MM/YYYY'),
                    published: false
                },

                lines: [],
                linesQuery: '',
                references: [],
                referencesQuery:'',
                materials: [],
                materialsQuery: '',
                colors: [],
                colorsQuery: ''


            }
        },
        ready(){

            //initializes algolia
//            this.client = algoliasearch('Y9WBZIWMX0', '463bcdaf034272d4a26167c5f82ba45e');
//            this.linesIndex = this.client.initIndex('lines');
        },
        methods:{
           // submitData: function(){},
//            getProduct() {
//                this.$http.get('/api/products/1')
//                        .then(response => {
//                    this.product = response.data;
//                });
//            },
        }
    }
</script>
