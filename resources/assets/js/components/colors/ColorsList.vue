<template>
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
    <div class="content-fluid" style="padding:20px;">
		<div class="row">
				<a class="color-holder" v-for="color in colors | filterBy search" @click="goToColor(color.id)">
					<div class="col-md-3 color-card">

							<div class="color-color" v-bind:style="{ 'background-color': color.color }">&nbsp;</div>
							<hr>
							<div style="text-align:right;">
							<span>
								<span><small>{{ color.description }}</small></span>
								<span class="h2" style="padding-left:10px;">{{ color.code }}</span>
								
							</span>
							 <br><br>
							</div>
							<div>
								<div class="color-pantone">{{ color.pantone }}</div>
							</div>

					</div>
				</a>

		</div>
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
            getColors: function () {
                var _this = this;
                this.$http.get('/api/colors/list?page='+this.page
                    +'&search='+encodeURIComponent(this.search))
                        .then(response => {
                            _this.colors = response.json().data;
                            _this.pagination = response.json();
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
        }
    }
</script>