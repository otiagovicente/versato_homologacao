<template>
    <div class="content-fluid">
        <div class="row">
            <div class="form-group form-line-input search">
                <h4>Buscar</h4>
                <input id="search-input" class="form-control input-sm" type="text" v-model="search" />
            </div>
        </div>
        <hr>
        <div class="row">
            <ul class="colors-list">
                <li v-for="color in colors | filterBy search" class="colors-list-item" @click="goToColor(color.id)">
                    <div class="colors-list-item-div" style="background-color:{{color.color}};">
                        <span class="colors-list-item-description">{{color.description}}</span>
                        <span class="colors-list-item-code">{{color.code}}</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</template>
<style>
    .search{
        position: relative;
        width: 95%;
        /*float: right;*/
        margin-left: 25px;
    }
    .colors-list{
        list-style-type: none;
        text-decoration: none;
        padding-left: 0px;
    }
    .colors-list-item{
        margin-bottom: 10px;
        cursor: pointer;

    }
    .colors-list-item-div {
        position: relative;
        border-radius: 8px;
        /*background-color: rgb(254, 238, 0);*/
        /*box-shadow: 0px 3px 7px 0px rgba(0, 0, 0, 0.43),inset 0px 3px 7px 0px rgba(0, 0, 0, 0.35);*/
        width: 95%;
        margin-left:20px;
        height: 100px;
        z-index: 2;
        color: #ececec;
    }
    .colors-list-item-description{
        position: absolute;
        right: 40px;
        top: 20px;
        font-weight: bolder;
        font-style: italic;
        font-size: 24pt;

    }
    .colors-list-item-code{
        position: absolute;
        right: 40px;
        top: 60px;
        font-style: italic;
        font-size: 12pt;
    }

</style>
<script>
    export default{
        data(){
            return{
                colors: [],
                search: ''
            }
        },
        ready(){
            window._this = this;
            _this.getColors();
        },
        methods:{
            getColors: function(){
                this.$http.get('/api/colors/'+Versato.brand_id)
                        .then(response => {
                            _this.colors = response.json();
                            console.log(response.json());
                        });

            },
            goToColor: function(color_id){
                window.location.href = '/colors/'+color_id;
            }
        }
    }
</script>
