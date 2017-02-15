<template>
    <div v-bind:id="dropdownId" class="btn-group">
        <button v-bind:id="id" class="btn red dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-angle-down"></i> <span v-if="option">{{option.description}}</span><span v-else>Filtrar</span>
        </button>
        <ul id="status_id" class="dropdown-menu" role="menu">
            <li v-for="action in data" class="{{action.color}}" v-on:click="setOption(action.id)"><a>{{action.description}}</a></li>
        </ul>
    </div>
</template>
<style scoped>

</style>
<script type="text/babel">
    export default{
        data(){
            return{
                dropdownId: 'dropdown-'+this._uid,
                id: 'button-'+this._uid
            }
        },
        props:{
            data : {},
            option : {
                type: Object,
                twoWay: true
            }
        },
        ready(){
        },
        methods: {
            setOption(id){
                var ColorButton = this;
                ColorButton.option = _.find(ColorButton.data, {'id' : id});
                ColorButton.buildButton();
                this.$dispatch('update');
            },
            buildButton(){
                var ColorButton = this;
                $('#'+ColorButton._uid).removeClass();
                $('#'+ColorButton._uid).addClass("btn "+ColorButton.option.color+" dropdown-toggle ");
                $('#'+ColorButton._uid).val(ColorButton.option.description);
            }
        }

    }
</script>
