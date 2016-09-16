<div id="app" class="content-fluid">
	<div class="portlet light">

        <div class="portlet-title">
            <div class="caption font-blue">
                @if($action==='edit')
                    <i class="fa fa-pencil font-blue"></i>Editar Produto
                @elseif($action==='create')
                    <i class="fa fa-plus font-blue"></i>Criar Produto
                @endif
            </div>
        </div>

        <div class="portlet-body form">
            <form id="form-product">
                @if($action==='edit')
                    {{ method_field('PATCH') }}
                @endif
                <input type="hidden" v-model="product.brand_id" name="brand_id" value="{{Session::get('brand')->id}}">

                <div class="row">
                    <div class="col-md-4">
                        <h3>Código:</h3>
                        <span class="h4" id="line-code">@{{ product.line_code }}</span>
                        <span class="h4"  id="reference-code">@{{ product.reference_code }}</span>
                        <span class="h4"  id="material-code">@{{ product.material_code }}</span>
                        <span class="h4"  id="color-code">@{{ product.color_code }}</span>
                        <input v-model="product.code" type="hidden" name="code" value="" id="code">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                            <small>Imagem</small>
                            <div id="photo-input" class="form-group">
                                <div class="">

                                      <img id="photo-image" @if($action ==='edit') src="{{ $product->photo }}" @else src="/images/default-placeholder.jpg" @endif  class="figure-img img-fluid img-rounded" alt="sem imagem do produto." style="width:200px;">
                                      <input id="photo-path" type="hidden" name="photo" value="" v-model="product.photo">

                                </div>
                            </div>
                            <div class="form-group">
                                <div id="photo" class="dropzone">
                                </div>
                            </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group form-line-input" id="line-input">
                            <small>Linha</small>
                            @if($action==='edit')
                                <input id="line" data-provide="typeahead" class="form-control input-sm" type="text"
                                       v-model="linesQuery"
                                       v-on:keyup.enter="searchLines"
                                       debounce="500" value="{{$product->line->description}}" readonly>

                            @elseif($action==='create')
                                <input id="line" data-provide="typeahead" class="typeahead form-control input-sm" type="text"
                                       v-model="linesQuery"
                                       v-on:keyup.enter="searchLines"
                                       debounce="500">

                            @endif




                        </div>
                        <div class="form-group form-line-input " id="reference-input">

                            <small>Referência</small>
                            @if($action==='edit')
                            <input id="reference" data-provide="typeahead" class="form-control input-sm" type="text"
                            v-model="referencesQuery"
                            v-on:keyup.enter="searchReferences"
                            debounce="500" readonly value="{{$product->reference->description}}">
                            @elseif($action==='create')
                            <input id="reference" data-provide="typeahead" class="typeahead form-control input-sm" type="text"
                            v-model="referencesQuery"
                            v-on:keyup.enter="searchReferences"
                            debounce="500">
                            @endif

                        </div>
                        <div class="form-group form-line-input " id="material-input">
                            <small>Material</small>
                            @if($action==='edit')
                            <input id="material" data-provide="typeahead" class="form-control input-sm" type="text"
                            v-model="materialsQuery"
                            v-on:keyup.enter="searchMaterials"
                            debounce="500" readonly value="{{$product->material->description}}">
                            @elseif($action==='create')
                            <input id="material" data-provide="typeahead" class="typeahead form-control input-sm" type="text"
                            v-model="materialsQuery"
                            v-on:keyup.enter="searchMaterials"
                            debounce="500">
                            @endif

                        </div>
                        <div class="form-group form-line-input" id="color-input">
                            <small>Cor</small>
                            @if($action==='edit')
                            <input id="color" class="form-control input-sm" type="text"
                            v-model="colorsQuery"
                            v-on:keyup.enter="searchColors"
                            debounce="500" readonly value="{{$product->color->description}}">
                            @elseif($action==='create')
                            <input id="color" class="typeahead form-control input-sm" type="text"
                            v-model="colorsQuery"
                            v-on:keyup.enter="searchColors"
                            debounce="500">
                            @endif

                        </div>
                        <div class="form-group form-line-input" id="launch-input">
                            <small>Lançamento</small><br>
                            <datepicker :value.sync="product.launch" format="dd/MM/yyyy" width="280px">
                            </datepicker>
                        </div>
                        <div class="form-group form-line-input" id="published-input">
                            <small>Publicado?</small><br>
                            <input type="checkbox" name="published" v-model="product.published">
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-line-input">
                            <small>Custo</small>
                            <input name="cost" type="text" v-model="product.cost | currencyDisplay" class="form-control" id="cost-input">

                        </div>
                        <div class="form-group form-line-input">
                            <small>Preço</small>
                            <input name="price" type="text" v-model="product.price | currencyDisplay" class="form-control" id="price-input">
                        </div>
                        <div class="form-group form-line-input">
                            <small>Grades</small>
                            <v-select :value.sync="product.grids" v-bind:options.sync="grids_select.options" placeholder="Selecione as grades"  multiple class="form-control" id="grids-input" name="grids[]" search justified required close-on-select></v-select>
                        </div>
                        <div class="form-group form-line-input">
                            <small>Tags</small>
                            <v-select :value.sync="product.tags" v-bind:options.sync="tags_select.options" multiple class="form-control" id="grids-input" name="grids[]" search justified required close-on-select></v-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr>
                    <div class="container-fluid">
                        <div class="col-md-3 pull-right">
                            <div class="form-group">
                                <button type="button" @@click="submitData()" class="btn blue btn-block" id="send-btn">Salvar</button>
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

@section('metatags')
    <meta id="token" name="csrf-token" content="{{ csrf_token() }}">
    <meta name="brand_id" content="{{ Session::get('brand')->id }}">
@stop
@section('styles')



	<link href="/dashboard/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="/dashboard/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <style>
        .dropzone {
            min-height: 150px;
            border: 2px dashed #eaeaea;
            background: white;
            padding: 20px 20px;
        }
    </style>


@stop

@section('scripts')

    <script>


        var data = {
            @if($action==='edit')
            actionUrl : '/products/{{$product->id}}',
            @elseif($action==='create')
            actionUrl : '/products',
            @endif


            @if($action==='edit')

            product: {
                code: '{{ $product->code }}',
                line_id: '{{ $product->line->id }}',
                line_code: '{{ $product->line->code }}',
                reference_id: '{{ $product->reference->id }}',
                reference_code: '{{ $product->reference->code }}',
                material_id: '{{ $product->material->id }}',
                material_code: '{{ $product->material->code }}',
                color_id: '{{ $product->color->id }}',
                color_code: '{{ $product->color->code }}',
                cost:{{ $product->cost }},
                price:{{ $product->price }},
                grids:[],
                tags:[],
                photo: '{{$product->photo}}',
                brand_id:{{$product->brand->id}},
                launch: '{{$product->launch->format('d/m/Y')}}',
                published: @if($product->published) true @else false @endif
            },

            @elseif($action==='create')
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
                photo: '',
                brand_id: '',
                launch: '{{ \Carbon\Carbon::now()->format('d/m/Y') }}',
                published: false
            },
            @endif

            lines: [],
            linesQuery: '',
            references: [],
            referencesQuery:'',
            materials: [],
            materialsQuery: '',
            colors: [],
            colorsQuery: '',
            grids_select: {
                options: [
                    @foreach($grids as $grid)
                {
                    value:{!!$grid->id!!},
                    label:'{!!$grid->description!!}'
                },
                @endforeach

                ]
            },

            tags_select: {
                options: [
                    @foreach($tags as $tag)
                {
                    value:{!!$tag->id!!},
                    label:'{!!$tag->description!!}'
                },
                @endforeach

                ]
            }


        };


    </script>








		<script src="/dashboard/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
	    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
	    <script src="https://cdn.jsdelivr.net/typeahead.js/0.11.1/typeahead.jquery.min.js" type="text/javascript" charset="utf-8"></script>



		<script type="text/javascript">Dropzone.autoDiscover = false;</script>

        {{--<script src="/dashboard/custom/products/form.js" type="text/javascript" charset="utf-8"></script>--}}

        <script>



            //ProductDropzone - Begin
            var ProductDropzone = function(){
                var dropzoneOptions = {
                    autoDiscover: false,
                    maxFiles: 1,
                    maxFileSize: 2,
                    paramName: 'photo',
                    acceptedFiles: '.jpeg, .jpg, .png',
                    autoProcessQueue: false,
                    dictDefaultMessage: 'Solte o arquivo aqui',
                    url: "/products/photo",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(file, response){
                        $('img#photo-image').attr("src", response);
                        $('#photo-path').attr("value", response);
                        Vue.set(data.product, 'photo', response);
                        console.log(data);
                        this.removeAllFiles(true);
                    },

                    init: function() {
                        this.on("maxfilesexceeded", function(file){
                            toastr.warning('Número de arquivos excedido!', 'Você só pode inserir um arquivo');
                        });
                        this.on("error", function(file, errorMessage){
                            console.log(errorMessage);
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
            }
            //ProductDropzone - End




            var vm = new Vue({
                el: '#app',
                data : data,
                components: {
                    vSelect: VueStrap.select,
                    vOption: VueStrap.option,
                    datepicker: VueStrap.datepicker,
                },
                ready: function(){



                    //initializes algolia
                    this.client = algoliasearch('Y9WBZIWMX0', '463bcdaf034272d4a26167c5f82ba45e');

                    //Lines Typeahead
                    this.linesIndex = this.client.initIndex('lines');
                    $('#line-input .typeahead')
                            .typeahead({hint: false},{
                                source: this.linesIndex.ttAdapter({
                                    filters: 'brand_id='+data.product.brand_id
                                }),
                                displayKey: 'description',
                                templates:{
                                    suggestion: function(hit){
                                        return '<div><strong>' + hit._highlightResult.description.value + '</strong> <small>'
                                                + hit.code + '</small></div>';
                                    }
                                }
                            })
                            .on('typeahead:select',function(e, suggestion){
                                this.linesQuery = suggestion.description;
                                data.product.line_id = suggestion.id;
                                data.product.line_code = suggestion.code;

                            }).bind(this);

                    //References Typeahead
                    this.referencesIndex = this.client.initIndex('references');
                    $('#reference-input .typeahead')
                            .typeahead({hint: false},{
                                source: this.referencesIndex.ttAdapter({
                                    filters: 'brand_id='+data.product.brand_id
                                }),
                                displayKey: 'description',
                                templates:{
                                    suggestion: function(hit){
                                        return '<div><strong>' + hit._highlightResult.description.value + '</strong> <small>'
                                                + hit.code + '</small></div>';
                                    }
                                }
                            })
                            .on('typeahead:select',function(e, suggestion){
                                this.referencesQuery = suggestion.description;
                                data.product.reference_id = suggestion.id;
                                data.product.reference_code = suggestion.code;
                            }).bind(this);

                    //Materials Typeahead
                    this.materialsIndex = this.client.initIndex('materials');
                    $('#material-input .typeahead')
                            .typeahead({hint: false},{
                                source: this.materialsIndex.ttAdapter({
                                    filters: 'brand_id='+data.product.brand_id
                                }),
                                displayKey: 'description',
                                templates:{
                                    suggestion: function(hit){
                                        return '<div><strong>' + hit._highlightResult.description.value + '</strong> <small>'
                                                + hit.code + '</small></div>';
                                    }
                                }
                            })
                            .on('typeahead:select',function(e, suggestion){
                                this.materialsQuery = suggestion.description;
                                data.product.material_id = suggestion.id;
                                data.product.material_code = suggestion.code;
                            }).bind(this);


                    //References Typeahead
                    this.colorsIndex = this.client.initIndex('colors');
                    $('#color-input .typeahead')
                            .typeahead({hint: false},{
                                source: this.colorsIndex.ttAdapter({
                                    filters: 'brand_id='+data.product.brand_id
                                }),
                                displayKey: 'description',
                                templates:{
                                    suggestion: function(hit){
                                        return '<div><div style="display:inline-block;height:20px; width:20px; margin:5px; background-color:'+hit.color+';"></div><strong>'+hit.code+'</strong> – '+hit.description+'</div>';
                                    }
                                }
                            })
                            .on('typeahead:select',function(e, suggestion){
                                this.colorsQuery = suggestion.description;
                                data.product.color_id = suggestion.id;
                                data.product.color_code = suggestion.code;
                            }).bind(this);



                    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

                    //ProductDropzone
                    ProductDropzone();
                    @if($action === 'edit')
                    data.product.code = '{{$product->code}}';
                    data.product.photo =  '{{$product->photo}}';
                    this.product.grids ={!! json_encode($product->gridlist)!!};
                    this.product.tags ={!!json_encode($product->taglist)!!};


                    @endif

                },
                methods: {
                    searchLines: function(){
                        this.linesIndex.search(this.linesQuery,{
                            filters: 'brand_id='+data.product.brand_id
                        }, function(error, results){
                            this.lines = results.hits;
                        }.bind(this));
                    },
                    searchReferences: function(){

                        this.referencesIndex.search(this.referencesQuery,{
                            filters: 'brand_id='+data.product.brand_id
                        }, function(error, results){
                            this.references = results.hits;
                        }.bind(this));
                    },
                    searchMaterials: function(){

                        this.materialsIndex.search(this.materialsQuery, {
                            filters: 'brand_id='+data.product.brand_id
                        },function(error, results){
                            this.materials = results.hits;
                        }.bind(this));
                    },
                    searchColors: function(){

                        this.colorsIndex.search(this.colorsQuery, {
                            filters: 'brand_id='+data.product.brand_id
                        },function(error, results){
                            this.colors = results.hits;
                        }.bind(this));
                    },

                    submitData: function(){

                        data.product.code = data.product.line_code.toString() + data.product.reference_code.toString() + data.product.material_code.toString() + data.product.color_code.toString();
                        data.product.code = parseInt(data.product.code);
                        data.product.launch = moment(data.product.launch, "DD/MM/YYYY").format("YYYY-MM-DD");
                        @if($action === 'edit')
                        this.$http.patch(data.actionUrl, data.product).then(function (response) {
                        @else
                        this.$http.post(data.actionUrl, data.product).then(function (response) {
                        @endif


                        toastr.success('Sucesso!','Produto atualizado com sucesso');
                        $('#code-input').removeClass('has-error');
                        $('#line-input').removeClass('has-error');
                        $('#reference-input').removeClass('has-error');
                        $('#material-input').removeClass('has-error');
                        $('#color-input').removeClass('has-error');
                        $('#price-input').removeClass('has-error');
                        $('#cost-input').removeClass('has-error');
                        $('#grids-input').removeClass('has-error');
                        $('#tags-input').removeClass('has-error');


                        // get status
                        response.status;

                        // get status text
                        response.statusText;

                        // get all headers
                        response.headers;

                        // get 'Expires' header
                        response.headers['Expires'];

                        // set data on vm
                        var productResponse = response.json();
                        window.location.href ='/products/'+productResponse.id;
                        console.log(productResponse.id);
                        // this.$set('someData', response.json())

                    }).catch(function (response) {

                            var errors = response.json();

                            $.each(errors, function (key, value) {

                                if(key === "line_id"){
                                    key = "line";
                                }
                                if(key === "reference_id"){
                                    key = "reference";
                                }
                                if(key === "material_id"){
                                    key = "material";
                                }
                                if(key === "color_id"){
                                    key = "color";
                                }

                                var input = '#' + key + '-input';
                                $(input).addClass('has-error');
                                toastr.error('Atenção!', value);

                            });
                        }).bind(this);


                    }

                },
                filters: {
                    currencyDisplay: {
                        // model -> view
                        // formats the value when updating the input element.
                        read: function (val) {
                            return '$' + parseFloat(val).toFixed(2);
                        },
                        // view -> model
                        // formats the value when writing to the data.
                        write: function (val, oldVal) {

                            var number = + val.replace(/[^\d.]/g, '');
                            return isNaN(number) ? 0 : parseFloat(number).toFixed(2);
                        }
                    }
                }

            });



        </script>

@stop

