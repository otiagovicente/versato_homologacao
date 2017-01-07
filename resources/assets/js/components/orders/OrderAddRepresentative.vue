<template>
    <div>
        <div class="modal fade" id="order-add-representative" tabindex="-1" role="order-add-representative" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="font-blue uppercase">Representantes</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-line-input search">
                                    <div class="input-icon input-icon-lg right">
                                        <i class="fa fa-search font-blue"></i>
                                        <input id="search-input" class="form-control input-lg" placeholder="Buscar" type="text" v-model="search" v-on:keyup.enter="searchRepresentatives()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 representatives-list">
                                <div class="col-md-12 representatives-list-box" v-for="representative in representatives" v-on:click="selectRepresentative(representative.id)">
                                    <h3 class="font-blue"><strong>{{ representative.user.name+' '+representative.user.lastname }}</strong></h3>
                                    <h4>{{representative.user.email}} <small>codigo: {{representative.code}}</small></h4>

                                    <hr>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style scoped>
    .representatives-list{
        height: 500px;
        overflow : scroll;
    }
    .representatives-list-box:hover{
        background-color: #eaeaea;
        cursor: pointer;
    }
</style>
<script type="text/babel">

    export default{
        data(){
            return{
                search: '',
                representatives : {}
            }
        },
        ready(){
            window._OrderAddRepresentative = this;
        },
        methods : {
            searchRepresentatives(){
                this.$http.get('/api/representatives/search?search='+_OrderAddRepresentative.search)
                        .then(response => {
                            this.representatives = response.json();
                        })
                        .catch(response => {
                            toastr.error('No fue possible cargar los representantes');
                        }).bind(this);
            },
            selectRepresentative(representative_id){
                this.$http.post('/shopping-cart/set-representative/'+representative_id)
                        .then(response => {
                            toastr.success('Representante eligido con exito');
                            this.$dispatch('load-order');
                            _OrderAddRepresentative.closeWindow();
                        })
                        .catch(response => {
                            toastr.error('No fué possible eligir el representante');
                        });


            },
            /*
             *  Funções de Janela
             */
            openWindow(){
                $('#order-add-representative').on("hide.bs.modal", function (e) {
                    _OrderAddRepresentative.reload();
                });
                $('#order-add-representative').modal();

            },
            closeWindow(){
                $('#order-add-representative').modal('hide');
            },
            reload(){

                _OrderAddRepresentative.search = "";
                _OrderAddRepresentative.representatives = {};
            },
        }
    }
</script>
