<template>
    <input type="checkbox" checked class="make-switch" data-label-icon="fa fa-fullscreen"
           data-on-text="<i class='fa fa-check'></i>"
           data-off-text="<i class='fa fa-times'></i>">
</template>
<style scoped>

</style>
<script type="text/babel">
    export default{
        data(){
            return {
                el: null
            }
        },
        props: {
            model: {
                type: Boolean,
                twoWay: true
            }
        },
        ready(){
            var _Switch = this;
            _Switch.el = this.$el;
            this.initialize();
        },
        methods: {
            initialize(){
                var _Switch = this;
                $(_Switch.el).bootstrapSwitch();
            }
        }
    }
</script>
