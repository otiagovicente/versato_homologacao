<template>
    <div>
        <header-component/>
        <div class="color-item">this is template body</div>
        <other-component/>
    </div>
</template>
<style>
    body{
        background-color:#ff0000;
    }
    .color-item {
        border-radius: 10px;
        background-color: rgb(254, 238, 0);
        box-shadow: 0px 3px 7px 0px rgba(0, 0, 0, 0.43),inset 0px 3px 7px 0px rgba(0, 0, 0, 0.35);
        width: 100%;
        height: 145px;
        z-index: 2;
    }

</style>
<script>
    import HeaderComponent from './components/header.vue'
    import OtherComponent from './components/other.vue'
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        components:{
            'other-component':OtherComponent,
            HeaderComponent,
        }
    }
</script>
