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
            <ul class="representatives-list">
                <li v-for="representative in representatives | filterBy search" class="representatives-list-item" @click="goToRepresentative(representative.id)">
                    <div class="representatives-list-item-div">
                        <span class="representatives-list-item-description">{{representative.user.name+' '+representative.user.lastname}}</span>
                        <span class="representatives-list-item-code">{{representative.code}}</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="content-fluid" style="padding:20px;">
            <div class="row">
            <ul class="pagination">
                <li><a v-on:click="setPage(page - 1)">Previous</a></li>
            </ul>
            <ul class="pagination" v-for="n in pagination.last_page">
                <li><a v-on:click="setPage(n+1)">{{ n+1 }}</a></li>
            </ul>
            <ul class="pagination">
                <li><a v-on:click="setPage(page + 1)">Next</a></li>
            </ul>
        </div>
    </div>

</template>

<style scoped>

    .search{
        position: relative;
        width: 95%;
        /*float: right;*/
        margin-left: 25px;
    }
    .representatives-list{
        list-style-type: none;
        text-decoration: none;
        padding-left: 0px;
    }
    .representatives-list-item{
        margin-bottom: 10px;
        cursor: pointer;

    }
    .representatives-list-item-div {
        position: relative;
        border-radius: 2px;
        background-color: #4276a4;
        /*box-shadow: 0px 3px 7px 0px rgba(0, 0, 0, 0.43);*/
        width: 95%;
        margin-left:20px;
        height: 80px;
        z-index: 2;
        color: #f0f0f0;
    }
    .representatives-list-item-description{
        position: absolute;
        right: 40px;
        top: 20px;
        font-weight: bolder;
        font-size: 18pt;

    }
    .representatives-list-item-code{
        position: absolute;
        right: 40px;
        top: 45px;
        font-size: 12pt;
    }

</style>
<script>
    export default{
        data(){
            return{
                representatives:{},
                pagination: {},
                page: 1
            }
        },
        components:{
        },
        ready(){
            window._this = this;
            _this.getRepresentatives();
        },
        methods : {
            getRepresentatives: function () {
                var _this = this;
                this.$http.get('/api/representatives/selectlist?page='+this.page)
                        .then(response => {
                            _this.representatives = response.json().data;
                            _this.pagination = response.json();
                        });
            },
            setPage(n){
              if (n < 1){
                n = 1;
              }
              if (n > this.pagination.last_page){
                n = this.pagination.last_page;
              }
              this.page=n;
              this.getRepresentatives();
            },
            goToRepresentative: function(representative_id){
                window.location.href = '/representatives/'+representative_id+'/grantaccess';
            }
        }
    }
</script>
