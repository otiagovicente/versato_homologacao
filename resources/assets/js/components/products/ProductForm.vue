<style scoped>
    .dropzone {
        min-height: 150px;
        border: 2px dashed #eaeaea;
        background: white;
        padding: 20px 20px;
        width: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: "Open Sans",sans-serif;
        font-weight: 300;
        font-size: 18px;
    }
    .product-photo {
        width:200px;
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
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <small>Foto</small>
                            <div id="photo-input" class="form-group">
                                <div class="">
                                    <img id="photo-image"  v-bind:src="product.photo" class="figure-img img-fluid img-rounded product-photo" alt="sem imagem do produto.">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="photo" class="dropzone">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small>Imagem</small>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group form-line-input">
                                <small>Costo</small>
                                <!--<input name="cost"-->
                                       <!--type="text"-->
                                       <!--v-model="product.cost | currencyDisplay"-->
                                       <!--class="form-control"-->
                                       <!--id="cost-input">-->
                                <!--<input type="number">-->

                            </div>
                            <div class="form-group form-line-input">
                                <small>Precio</small>
                                <input name="price"
                                       type="text"
                                       v-model="product.price"

                                       class="form-control"
                                       id="price-input">
                            </div>
                            <!--<div class="form-group form-line-input">-->
                                <!--<small>Tareas</small>-->
                                <!--<v-select v-bind:options.sync="grids_select.options" :value.sync="product.gri-->
                                <!--ds" placeholder="Elije as grades"  multiple class="form-control" id="grids-input" name="grids[]" search justified required close-on-select></v-select>-->
                            <!--</div>-->
                            <!--<div class="form-group form-line-input">-->
                                <!--<small>Tags</small>-->
                                <!--<v-select v-bind:options.sync="tags_select.options" :value.sync="product.tags"  placeholder="Elije as tags" multiple class="form-control" id="grids-input" name="grids[]" search justified required close-on-select></v-select>-->

                            <!--</div>-->

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
import Dropzone from 'dropzone'
import toastr from 'toastr'
import bootbox from 'bootbox'

Vue.filter('currencyDisplay', {
    // model -> view
    // formats the value when updating the input element.
    read: function(val) {
        return '$'+val.toFixed(2)
    },
    // view -> model
    // formats the value when writing to the data.
    write: function(val, oldVal) {
        var number = +val.replace(/[^\d.]/g, '')
        return isNaN(number) ? 0 : parseFloat(number.toFixed(2))
    }
})

export default{
    components: {
            typeahead : VueTypeahead,
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
                launch: '',
                published: false
            },

            lines: [],
            linesQuery: '',
            references: [],
            referencesQuery:'',
            materials: [],
            materialsQuery: '',
            colors: [],
            colorsQuery: '',
            grids_select: [
                options => []
            ],
            tags_select: [
                options => []
            ]


        }
    },
    ready(){


        this.product.launch = moment().format('DD/MM/YYYY');
        this.configureDropbox(this.product);
//        this.getTags();
//        this.getGrids();



        //initializes algolia
//            this.client = algoliasearch('Y9WBZIWMX0', '463bcdaf034272d4a26167c5f82ba45e');
//            this.linesIndex = this.client.initIndex('lines');
    },
    methods:{
         submitData: function(){},
        getGrids() {
            this.$http.get('/api/grids/selectlist/1')
                    .then(response => {
                this.grids_select = response.data;
                console.log(response);
            });
        },
        getTags() {
            this.$http.get('/api/tags/selectlist/1')
                    .then(response => {
                this.tags_select = response.data;
            });
        },
        configureDropbox: function(callback){
            Dropzone.autoDiscover = false;
            var dropzoneOptions = {
                maxFiles: 1,
                maxFileSize: 2,
                paramName: 'photo',
                acceptedFiles: '.jpeg, .jpg, .png',
                autoProcessQueue: false,
                dictDefaultMessage: 'Elije el archivo',
                url: "/products/photo",
                headers: {
                    'X-CSRF-TOKEN': Laravel.csrfToken
                },

                success: function(file, response){
                    Vue.set(callback, 'photo', response);
                    this.removeAllFiles(true);
                },

                init: function() {
                    this.on("maxfilesexceeded", function(file){
                        toastr.warning('Número de arquivos excedido!', 'Você só pode inserir um arquivo');
                    });
                    this.on("error", function(file, errorMessage){
                        toastr.error('Erro!', "Confira se o arquivo possui as características necessárias!");
                        this.removeAllFiles(true);
                    });
                }

            };
            var photoDropzone = new Dropzone("div#photo", dropzoneOptions);

            photoDropzone.accept = function(file, done) {

                bootbox.confirm("Tem certeza que quer fazer o upload da imagem do produto?", function(result) {
                    if(result){
                        done();
                        photoDropzone.processQueue();
                    }else{
                        photoDropzone.removeAllFiles(true);
                        done(result);
                    }
                });
            };



        },

//        filters: {
//            currencyDisplay: {
//                // model -> view
//                // formats the value when updating the input element.
//                read: function (val) {
//                    return '$' + val.toFixed(2);
//                },
//                // view -> model
//                // formats the value when writing to the data.
//                write: function (val, oldVal) {
//
//                    var number = + val.replace(/[^\d.]/g, '');
//                    return isNaN(number) ? 0 : parseFloat(number).toFixed(2);
//                }
//            }
//        }


    }
}



</script>
