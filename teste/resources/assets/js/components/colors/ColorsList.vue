<template>
    <div class="content-fluid">
        <div class="row">
            <div class="form-group form-line-input search">
                <h4>Buscar</h4>

                <div class="input-icon input-icon-lg right">
                    <i class="fa fa-search font-green"></i>
                    <input id="search-input" class="form-control input-lg" type="text" v-model="search" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="md-col-12">
                <div class="col-md-12">
                  <div class="col-md-2">
                    <div class="form-group">
                      <select class="form-control" v-model="entries" v-on:change="getColors()">
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select class="form-control" v-model="cp" v-on:change="setCampo(cp)">
                        <option>code</option>
                        <option>description</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <hr>
        <div class="row">
            <ul class="colors-list">
                <li v-for="color in colors.data.data" class="colors-list-item" @click="showColor(color.id)">
                    <div class="colors-list-item-div" style="background-color:{{color.color}};">
                        <span class="colors-list-item-description">{{color.description}}</span>
                        <span class="colors-list-item-code">{{color.code}}</span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="row">
            <ul class="pagination">
              <li><a v-on:click="setPage(page - 1)">Previous</a></li>
            </ul>
            <ul class="pagination" v-for="n in lines.data.last_page">
              <li><a v-on:click="setPage(n+1)">{{ n+1 }}</a></li>
            </ul>
            <ul class="pagination">
              <li><a v-on:click="setPage(page + 1)">Next</a></li>
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
        margin-bottom: 15px;
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
              colors: {
                  data: {
                    data: [],
                },
              },
              search: '',
              entries: 10,
              page: 1,
              campo: 'code',
              cp: '',
              sequence: 'asc',
            }
        },
        watch: {
            'search': function (val) {
                _this.getColors();
            },
            'lines.data.last_page': function (val) {
               if(_this.page > val){
                 _this.setPage(val);
               }

            }
        },
        ready(){
            window._this = this;
            _this.getColors();
        },
        methods:{
            getColors: function(){
                this.$http.get('/api/colors/'+Versato.brand_id+'?page=' + _this.page +
                '&entries=' + _this.entries  +
                '&campo='+_this.campo +
                '&sequence='+_this.sequence +
                '&search='+_this.search)
                .then((response) => {

                    _this.colors = response;

                }).catch((response) => {
                    toastr.error('No fué posible conectar al servidor');
                });

            },
            showColor: function(color_id){
                window.location.href = '/colors/'+color_id;
            }
            setPage(n){
              if (n < 1){
                n = 1;
              }
              if (n > _this.lines.data.last_page){
                n = _this.lines.data.last_page;
              }
              _this.page=n;
              _this.getColors();
            },
            setCampo(cp){
              if (_this.campo != cp){
                _this.sequence = 'asc';
              }else{
                _this.sequence = 'desc';
              }
              _this.campo = cp;
              _this.getColors();
            }
        }
    }
</script>
