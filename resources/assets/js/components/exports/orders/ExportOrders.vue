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
    <hr/>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Numero</>
                <th>Cliente</th>
                <th>Cod_alfa</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="5">
                    <button type="button" @click="export" class="btn blue">Exportar Excel</button>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr v-for="o in lstOrders">
                <td>{{o[0]}}</td>
                <td>{{o[1]}}</td>
                <td>{{o[2]}}</td>
                <td>{{o[3]}}</td>
                <td>{{o[4]}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import VueStrap from 'vue-strap'
    import toastr from 'toastr'
    
    export default {
        components: {
            datepicker: VueStrap.datepicker
        },
        
        data(){
            return{
                dtInicial:moment().add(-30, 'days').format('DD/MM/YYYY'),
                dtFinal:moment().format('DD/MM/YYYY'),
                lstOrders:new Array(),
            }
        },
        
        ready: function () {
           this.loadListOrders();
        },
        
        methods:{
            toDate(date, tipo){
                var arrDate = date.split('/');
                var returnDate = (arrDate[2] + "-" + arrDate[1] + "-" + arrDate[0]);
                
                if(tipo == 'ini')
                    return returnDate + ' 00:00:00'
                else{
                    return  returnDate + ' 23:59:59'
                }
            },
            
            loadListOrders(brand){
                this.$http.get('/api/orders/exportListOrdersByDate/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal))
                .then(response => {
                    this.lstOrders = response.json();
                    console.log(response.json());
                });
            },
            
            export(){
                var url = ('/orders/exportOrdersByDate/'+ this.toDate(this.dtInicial, 'ini') + '/' + this.toDate(this.dtFinal));
                window.open(url);
            },
        },
        watch:{
            'dtInicial': function (val, oldVal) {
                if(this.dtInicial && this.dtFinal) this.loadListOrders();
            },
            'dtFinal': function (val, oldVal) {
                if(this.dtInicial && this.dtFinal) this.loadListOrders();
            },
        },
    }
</script>