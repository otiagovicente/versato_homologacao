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
                <th>Região</>
                <th>Total Pedidos</th>
                <th>Valor Total de Pedidos</th>
                <th>Aciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="m in marcas">
                <td>{{m.name}}</td>
                <td>{{m.qtd_pedidos}}</td>
                <td>{{m.Total | currency}}</td>
                <td>
                    <button type="button" @click="loadListOrders(m.id)" class="btn blue" data-toggle="modal" 
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
                
                marcas:    new Array(),
                labels:    new Array(),
                datasets:  new Array(),
                lstOrders: new Array(),
            }
        },
        
        ready: function () {
            this.loadChart();
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
                this.$http.get('/api/orders/getOrdersByRegion/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal))
                .then(response => {
                    
                    this.labels = new Array();
                    this.datasets = new Array();
                    var data = response.json();
                    
                    for(var i=0; i < data.length; i++){
                        this.labels.push(data[i].name);
                        this.datasets.push({
                            label:data[i].description
                            , data: (this.tipo == 'quantidade'? [data[i].qtd_pedidos]:[data[i].Total])
                        });
                    }
                    this.loadTableData(data);
                });
            },
            loadTableData(data){
                var marcas = new Array();
                console.log(data);
                for(var i=0; i < data.length; i++){
                    marcas.push({
                            id:data[i].id,
                            name:data[i].description, 
                            qtd_pedidos:[data[i].qtd_pedidos], 
                            Total:[data[i].Total]
                    });
                }
                this.marcas = marcas;
            },
            
            loadListOrders(id){
                this.$http.get('/api/orders/getOrdersListByRegion/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal) + '/' + id)
                .then(response => {
                    this.lstOrders = response.json();
                });

            },
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