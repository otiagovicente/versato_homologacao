<template>
    <div class="row">
        <div class="md-col-12">
            <div class="col-md-12">
                <div class="form-group form-line-input search">
                    <h4>Buscar</h4>
                    <div class="input-icon input-icon-lg right">
                        <i class="fa fa-search font-green"></i>
                        <input id="search-input" class="form-control input-lg" type="text" name="search" v-model="search" v-on:keyup.enter="getColors(true)" />
                    </div>
                </div>
            </div>
            <div class="col-md-5 pull-right">
            </div>
        </div>
    </div>

    <pagination-bar :pages="pagination.last_page" :page="page" @select="setPage"></pagination-bar>

    <div class="content-fluid" style="padding:20px;">
        <div class="row">
            <a class="color-holder" v-for="color in colors" @click="goToColor(color.id)">
                <div class="col-md-3 color-card">

                    <div class="color-color" v-bind:style="{ 'background-color': color.color }">&nbsp;</div>
                        <hr />
                        <div class="color-caption">
                        <span>
                            <span><small>{{ color.description }}</small></span>
                            <span class="h2" style="padding-left:10px;">{{ color.code }}</span>
                        </span>
                        <br /><br />
                    </div>
                    <div>
                        <div class="color-pantone">{{ color.pantone }}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <pagination-bar :pages="pagination.last_page" :page="page" @select="setPage"></pagination-bar>


</template>

<style scoped>

    .search{
        position: relative;
        width: 95%;
        /*float: right;*/
        margin-left: 25px;
    }

    .color-holder {
        color:black;
        text-decoration:none!important;
    }

    .color-card {
        padding-top:20px;
        padding-bottom:20px;
        margin:10px;
        box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
    }

    .color-pantone {
        display:block;
        text-align:right;
        padding-right:5px;
    }

    .color-color {
        width:100%;
        height:180px;
    }

    .color-caption {
        text-align: right;
        height: 52px;
        overflow: hidden;
    }

</style>
<script>
    export default{
        data(){
            return{
                colors:{},
                pagination: {},
                page: 1,
                search: ''
            }
        },
        components:{
        },
        ready(){
            window._this = this;
            _this.getColors(); 
        },
        methods : {
            getColors: function (reset) {
                var _this = this;
                var page = reset ? 1 : this.page
                this.$http.get('/api/colors/list?page=' + page
                    +'&search='+encodeURIComponent(this.search))
                        .then(response => {
                            _this.page = page
                            _this.colors = response.json().data;
                            _this.pagination = response.json();
                            _this.scrollTop();
                        });
            },
            goToColor: function(color){
                window.location.href = '/colors/'+color;
            },
            setPage(n){
                if (n < 1){
                    n = 1;
                }
                if (n > this.pagination.last_page){
                    n = this.pagination.last_page;
                }
                this.page=n;
                this.getColors();
            },
            scrollTop() {
                $("html, body").animate({scrollTop:0}, 500);
            }
        }
    }
</script>