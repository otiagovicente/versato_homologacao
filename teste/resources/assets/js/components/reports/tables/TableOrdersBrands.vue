<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Marca</>
                <th>Total Pedidos</th>
                <th>Valor Total de Pedidos</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="m in marcas">
                <td>{{m.name}}</td>
                <td>{{m.qtd_pedidos}}</td>
                <td>{{m.Total}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        data(){
            return{
                tipo:'quantidade',
                dtInicial:moment().add(-30, 'days').format('DD/MM/YYYY'),
                dtFinal:moment().format('DD/MM/YYYY'),
                labels:   new Array(),
                datasets: new Array(),
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
                this.$http.get('/api/orders/getOrdersByBrand/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal))
                .then(response => {
                    var datasets = new Array();
                    var labels = new Array();
                    var data = response.json();
                    
                    for(var i=0; i < data.length; i++){
                        labels.push(data[i].name);
                        datasets.push({
                            label:data[i].name
                            , data: (this.tipo == 'quantidade'? [data[i].qtd_pedidos]:[data[i].Total])
                        });
                    }
                    
                    this.labels = labels;
                    this.datasets = datasets;
                });
            }
        },
        watch:{
            'tipo': function (val, oldVal) {
                this.loadChart();
            },
            'dtInicial': function (val, oldVal) {
                this.loadChart();
            },
            'dtFinal': function (val, oldVal) {
                this.loadChart();
            },
        },
    }
</script>