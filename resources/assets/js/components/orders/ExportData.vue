<template>
    <li id="export-data">
        <a class="export-data-excel" v-on:click="exportToExcel()">Exportar para excel</a>
    </li>
</template>
<script type="text/babel">
    export default{
        data(){
            return {}
        },
        ready(){
            
        },
        methods: {
            exportToExcel: function() {
                this.$parent.$emit('fromRoot');
            }
        }
    }
</script>
