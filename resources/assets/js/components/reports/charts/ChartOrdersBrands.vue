<template>
    <div class="col-md-2">
        <small>Inicio</small>
        <div class="form-group form-line-input" id="launch">
            <datepicker :value.sync="dtInicial" format="dd/MM/yyyy" width="100%">
            </datepicker>
        </div>
    </div>
    <div class="col-md-2">
        <small>Fim</small>
        <div class="form-group form-line-input" id="launch">
            <datepicker :value.sync="dtFinal" format="dd/MM/yyyy" width="100%">
            </datepicker>
        </div>
    </div>
    <div class="col-md-2">
        <small>Tipo</small>
        <div class="form-group form-line-input" id="launch">
            <v-select :options="select.options" options-value="val" :value.sync="tipo" ></v-select>
        </div>
    </div>
    <div class="col-md-2">
        <small></small>
        <span class="input-group-btn">
            <button class="btn blue" type="button" @click="loadChart">Buscar</button>
        </span>
    </div>

    <canvas v-el:canvas style="width: 100%; height: 200px"></canvas>
    
    <hr/>
    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Marca</>
                <th>Total Pedidos</th>
                <th>Valor Total de Pedidos</th>
<<<<<<< HEAD
=======
                <th>Aciones</th>
>>>>>>> 9db5c1bc97c2bfe08339dca5aeb120c81be4919a
            </tr>
        </thead>
        <tbody>
            <tr v-for="m in marcas">
                <td>{{m.name}}</td>
                <td>{{m.qtd_pedidos}}</td>
                <td>{{m.Total | currency}}</td>
<<<<<<< HEAD
            </tr>
        </tbody>
    </table>
=======
                <td>
                    <button type="button" @click="loadListOrders" class="btn blue" data-toggle="modal" 
                        data-target="#myModal"
                    >Pedidos</button>
                </td>
            </tr>
        </tbody>
    </table>

<div id="myModal" class="modal fade .modal-lg" role="dialog">
  
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pedidos</h4>
      </div>
      <div class="modal-body">
          <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Representante</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Desc. Cliente</th>
                    <th>Desc. Representante
                    <th>Qtd. Productos</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in lstOrders">
                    <td>#{{ order.id}}</td>
                    <td>
                        {{order.representative.user.name}}
                    </td>
                    <td>${{order.cost}}</td>
                    <td>${{order.price}}</td>
                    <td>{{order.client_discount}}</td>
                    <td>{{order.representative_discount}}</td>
                    <td>{{order.products.length}}</td>
                    <td>${{order.total}}</td>
                    <td>
                        <a class="btn blue btn-outline sbold"
                           data-toggle="modal"
                           href="#"
                           v-on:click="alert('bla bla bla')"
                        >
                            Editar
                        </a>

                    </td>
                </tr>
            </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



>>>>>>> 9db5c1bc97c2bfe08339dca5aeb120c81be4919a
</template>

<script>
    import Chart from 'chart.js'
    import VueStrap from 'vue-strap'
    import toastr from 'toastr'
    
    export default {
        components: {
            vSelect: VueStrap.select,
            vOption: VueStrap.option,
            datepicker: VueStrap.datepicker
        },
        
        data(){
            return{
                chart:'',
                type:'bar',
                tipo:'quantidade',
                dtInicial:moment().add(-30, 'days').format('DD/MM/YYYY'),
                dtFinal:moment().format('DD/MM/YYYY'),
                select: {
                    options: [
                        {val: 'quantidade', label: 'Quantidade'},
                        {val: 'vendas', label: 'Total de Vendas'},
                    ],
                },
                marcas:   new Array(),
                labels:   new Array(),
                datasets: new Array(),
<<<<<<< HEAD
=======
                lstOrders:new Array(),
>>>>>>> 9db5c1bc97c2bfe08339dca5aeb120c81be4919a
            }
        },
        
        ready: function () {
            this.loadChart();
<<<<<<< HEAD
=======
            this.export();
>>>>>>> 9db5c1bc97c2bfe08339dca5aeb120c81be4919a
        },
        
        methods:{
            loadChart(){
                this.getChartData();
                
                if(typeof(this.chart) == 'object') this.chart.destroy();
                
                let canvas = this.$els.canvas
                this.chart = new Chart(canvas, {
                    type: this.type,
                    
                    data: {
                        labels: ['Pedidos'],//this.labels,
                        datasets: this.datasets
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                })
            },
            toDate(date, tipo){
                var arrDate = date.split('/');
                var returnDate = (arrDate[2] + "-" + arrDate[1] + "-" + arrDate[0]);
                
                if(tipo == 'ini')
                    return returnDate + ' 00:00:00'
                else{
                    return  returnDate + ' 23:59:59'
                }
            },
            getChartData(){
                this.$http.get('/api/orders/getOrdersByBrand/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal))
                .then(response => {
                    this.labels = new Array();
                    this.datasets = new Array();
                    var data = response.json();
                    
                    for(var i=0; i < data.length; i++){
                        this.labels.push(data[i].name);
                        this.datasets.push({
                            label:data[i].name
                            , data: (this.tipo == 'quantidade'? [data[i].qtd_pedidos]:[data[i].Total])
                        });
                    }
                    this.loadTableData(data);
                });
            },
            loadTableData(data){
                var marcas = new Array();
                for(var i=0; i < data.length; i++){
                    marcas.push({name:data[i].name, qtd_pedidos:[data[i].qtd_pedidos], Total:[data[i].Total]});
                }
                this.marcas = marcas;
            },
<<<<<<< HEAD
=======
            
            loadListOrders(brand){
                this.$http.get('/api/orders/getOrdersListByBrand/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal) + '/01')
                .then(response => {
                    this.lstOrders = response.json();
                    console.log(this.lstOrders);
                });
            },
            
            export(){
                var url = ('/orders/exportOrdersByDate/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal));
                window.open(url);
            },
>>>>>>> 9db5c1bc97c2bfe08339dca5aeb120c81be4919a
        },
        watch:{
            'tipo': function (val, oldVal) {
                //this.loadChart();
            },
            'dtInicial': function (val, oldVal) {
                //this.loadChart();
            },
            'dtFinal': function (val, oldVal) {
                //this.loadChart();
            },
        },
    }
</script>