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
            <v-select :options="select.options" options-value="val" :value.sync="type" ></v-select>
        </div>
    </div>

    <canvas v-el:canvas style="width: 100%; height: 200px"></canvas>
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
                dtInicial:moment().add(-30, 'days').format('DD/MM/YYYY'),
                dtFinal:moment().format('DD/MM/YYYY'),
                select: {
                    options: [
                        {val: 'bar', label: 'Barra'},
                        //{val: 'line', label: 'Linea'},
                        {val: 'pie', label: 'Pizza'},
                        //{val: 'doughnut', label: 'doughnut'},
                        //{val: 'bubble', label: 'Balões'},
                        //{val: 'radar', label: 'Radar'},
                        //{val: 'polarArea', label: 'polarArea'},
                    ],
                },
                labels:  new Array(),
                datasets:new Array(),
            }
        },
        
        ready: function () {
            this.getChartData();
            //setTimeout( this.loadChart(), 4000);
        },
        
        methods:{
            loadChart(){
                if(typeof(this.chart) == 'object') this.chart.destroy();
                
                let canvas = this.$els.canvas
                this.chart = new Chart(canvas, {
                    type: this.type,
                    
                    data: {
                        labels: ['Sales'],//this.labels,
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
            
            getChartData(){
                this.$http.get('/api/orders/getSalesByBrand')
                .then(response => {
                    var datasets = new Array();
                    var data = response.json();
                    for(var i=0; i < data.length; i++){
                        this.labels.push(data[i].name);
                        datasets.push({
                            label:data[i].name
                            , data: [data[i].qtd_pedidos]
                        });
                    }
                    this.datasets = datasets;
                });
                this.loadChart();
            }
        },
        watch:{
            'type': function (val, oldVal) {
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