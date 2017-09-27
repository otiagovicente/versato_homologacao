<template>
    <div class="row">
        <div class="md-col-12">
            <div class="col-md-12">
                <div class="form-group form-line-input search">
                    <h4>Buscar</h4>
                    <div class="input-icon input-icon-lg right">
                        <i class="fa fa-search font-green"></i>
                        <input id="search-input" class="form-control input-lg" type="text" name="search" v-model="search" v-on:keyup.enter="loadList(true)" />
                    </div>
                </div>
            </div>
            <div class="col-md-5 pull-right">
            </div>
        </div>
    </div>

    <pagination-bar :pages="paginate.last_page" :page="page" @select="setPage"></pagination-bar>

    <div class="content-fluid" style="padding:20px;">
        <div class="row">
            <a class="item-holder" v-for="item in paginate.data" @click="goTo(item.id)">
                <div class="col-md-3" style=" padding-top:20px; padding-bottom:20px; margin:10px; box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);">
                    <div class="container" style="width:100%; height:180px;">
                        <img :src="item.sample" :alt="item.code" style="width:100%; height:100%;">
                    </div>
                    <hr />
                    <div style="text-align:right; overflow: hidden; height: 52px;">
                        <span>
                            <span><small>{{ item.description }}</small></span>
                            <span class="h2" style="padding-left:10px;">{{ item.code }}</span>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <pagination-bar :pages="paginate.last_page" :page="page" @select="setPage"></pagination-bar>


</template>

<style>
    .search{
        position: relative;
        width: 95%;
        /*float: right;*/
        margin-left: 25px;
    }

    .item-holder {
        color:black;
        text-decoration:none!important;
    }
</style>

<script>
    export default {
        data() {
            return {
                paginate: { data: [], last_page: 0 },
                page: 1,
                search: ''
            }
        },

        ready() {
            this.loadList(); 
        },

        methods: {
            loadList: function(reset) {
                var page = reset ? 1 : this.page
                this.$http.get('/api/materials/paginate?page=' + page
                +'&search=' + encodeURIComponent(this.search))
                .then(response => {
                    this.page = page;
                    this.paginate = response.json();
                    this.scrollTop();
                });
            },

            goTo: function(id){
                window.location.href = '/materials/' + id;
            },

            setPage(n) {
                this.page = n;
                this.loadList();
            },

            scrollTop() {
                $("html, body").animate({scrollTop:0}, 500);
            }
        }
    }
</script>