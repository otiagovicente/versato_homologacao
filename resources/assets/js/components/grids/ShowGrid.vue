<template>
    <div>
        <div class="row">
            <div class="col-md-10 col-md-offset -1">
                <div class="row">
                    <div class="col-md-5">
                        <h3>{{ grid.description }} - <small>Código: {{ grid.code }}</small> </h3>
                        <h4>País: {{ grid.locale }}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 grid-list-box">

                        <div v-for="size in grid.sizes">
                            <div class="col-md-1">

                                <div class="col-md-12 show-grid-table-header">{{size.size}}</div>
                                <div class="col-md-12 show-grid-table-body">{{size.pivot.amount}}</div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</template>
<style scoped>

    .grid-list-box{

        background-color: #eaeaea;
        border: 1px #4C87B9 solid;
        border-radius: 5px;
        text-align: center;
    }

</style>
<script type="text/babel">
    export default{
        data(){
            return{
                grid : []
            }
        },
        props:['id'],
        ready(){
            window._ShowGrid = this;
            _ShowGrid.loadGrid();
        },
        methods:{

            loadGrid(){

                this.$http.get('/api/grids/'+_ShowGrid.id)
                        .then(response=>{
                            _ShowGrid.grid = response.json();
                        })
                        .catch(response => {
                            toastr.error('no fue possible cargar la grid');
                        });

            }

        }
    }
</script>
