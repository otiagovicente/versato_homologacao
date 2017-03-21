<template>
    <div>

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-10">

                    <div class="col-md-6">

                        <div class="ipad-box">

                            {{{ qrcode }}}

                        </div>

                    </div>
                    <div class="col-md-6 blue call-to-action">

                        <br><br>

                        <h1>Accesso a Versato App!</h1>

                        <p> En tu email del sistema, irás obtener un QR Code, utilizas tu ipad para que tu usuario gane accesso al app en un pase magia!</p>

                        <button type="button" class="btn blue btn-primary btn-lg btn-block" @click="grantAccess()">Obtener Acesso!</button>


                    </div>

                </div>

            </div>

        </div>


    </div>
</template>
<style scoped>


    .call-to-action{
        text-align:center;
    }
    .ipad-box{

    }
    .ipad-box img{

        height: 400px;

    }
</style>
<script type="text/babel">



    export default{
        data(){
            return{
                representative: '',
                qrcode : '<img src="/images/iPadAirWhite.png" style="height:400px;">'
            }
        },
        props: ['representativeid'],
        ready(){
            window._GrantAccessToVersatoApp = this;

        },
        methods:{

            grantAccess(){

                this.$http.post('/representatives/'+_GrantAccessToVersatoApp.representativeid+'/grantaccess')
                          .then(response => {
                              _GrantAccessToVersatoApp.qrcode = response.data;
                          })
                          .catch(response => {
                                toastr.error('No fué possible generar el QR Code');
                          })

            }

        }

    }
</script>
