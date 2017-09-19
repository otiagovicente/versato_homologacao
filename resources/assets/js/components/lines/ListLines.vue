<template>
    <div>
        <div class="row">
            <div class="md-col-12">
                <div class="col-md-12">
                    <div class="form-group form-line-input search">
                        <h4>Buscar</h4>
                        <div class="input-icon input-icon-lg right">
                            <i class="fa fa-search font-green"></i>
                            <input id="search-input" class="form-control input-lg" type="text" v-model="search">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 pull-right">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="md-col-12">
                <div class="col-md-12">
                  <div class="col-md-2">
                    <div class="form-group">
                      <select class="form-control" v-model="entries" v-on:change="getlines()">
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


        <div class="container-fluid">

      			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" v-for="line in lines.data.data">
      				<a class="dashboard-stat dashboard-stat-v2 grey" v-on:click="goToline(line.id)">
      					<div class="visual">
      						<i class="fa fa-sitemap"></i>
      					</div>
      					<div class="details">
      						<div class="number">
      							<span>{{line.code}}</span>
      						</div>
      						<div class="desc"> {{line.description}}
                              </div>
                          </div>

      				</a>
      			</div>
      	</div>


        <div class="content-fluid" style="padding:20px;">
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
    </div>
</template>

<style scoped>

    .search-box{
        width:100%;
        margin-bottom: 40px;
    }
    .list-customer-index-list-photo{

        width: 100%;

    }

    .list-customer-index-product-box{

        background-color: #FFFFFF;
        bline: 3px solid #ebeef0;
        bline-radius: 15px;
        padding: 20px;
        margin-bottom: 15px;
        text-align: center;



    }

</style>
<script type="text/babel">

    export default{
        data(){
            return{
                lines: {
                    data: {
                      data: [],
                  },
                },
                search: '',
                entries: 10,
                page: 1,
                campo: 'id',
                cp: '',
                sequence: 'asc',
            }
        },
        watch: {
            'search': function (val) {
                _listlines.getlines();
            },
            'lines.data.last_page': function (val) {
               if(_listlines.page > val){
                 _listlines.setPage(val);
               }

            }
        },
        ready(){
            window._listlines = this;
            _listlines.getlines();

        },
        methods:{
            getlines: function(){
                this.$http.get('/api/lines/listIndex?page=' + _listlines.page +
                '&entries=' + _listlines.entries  +
                '&campo='+_listlines.campo +
                '&sequence='+_listlines.sequence +
                '&search='+_listlines.search)
                    .then((response) => {

                        _listlines.lines = response;

                    }).catch((response) => {
                        toastr.error('No fué posible conectar al servidor');
                    });
            },
            goToline(line_id){
                window.location.href = '/lines/'+ line_id;
            },
            setPage(n){
              if (n < 1){
                n = 1;
              }
              if (n > _listlines.lines.data.last_page){
                n = _listlines.lines.data.last_page;
              }
              _listlines.page=n;
              _listlines.getlines();
            },
            setCampo(cp){
              if (_listlines.campo != cp){
                _listlines.sequence = 'asc';
              }else{
                _listlines.sequence = 'desc';
              }
              _listlines.campo = cp;
              _listlines.getlines();
            }
        }
    }
</script>
