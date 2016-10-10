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

</template>

<style>

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
                representatives:{}
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
                this.$http.get('/api/representatives/')
                        .then(response => {
                            _this.representatives = response.json();
                        });
            },
            goToRepresentative: function(representative_id){
                window.location.href = '/representatives/'+representative_id;
            }
        }
    }
</script>
