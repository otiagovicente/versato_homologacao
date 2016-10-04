<template>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet ">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img v-bind:src="user.photo" class="img-responsive" alt=""> </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> {{user.name + ' ' + user.lastname}} </div>
                        <div class="profile-usertitle-job"> {{user.occupation}} </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li class="active">
                                <a href="{{'/users/'+user.id}}">
                                    <i class="icon-home"></i> Perfil </a>
                            </li>
                            <li>
                                <a href="{{'/users/'+user.id+'/edit'}}">
                                    <i class="icon-settings"></i> Cambiar info </a>
                            </li>
                            <li>
                                <a href="/help">
                                    <i class="icon-info"></i> Ayuda </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
                <!-- END PORTLET MAIN -->
                <!-- PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
</template>
<style>

    /* Cubic Bezier Transition */
    /***
    New Profile Page
    ***/
    .profile-sidebar {
        float: left;
        width: 300px;
        margin-right: 20px; }

    .profile-content {
        overflow: hidden; }

    /* PROFILE SIDEBAR */
    .profile-sidebar-portlet {
        padding: 30px 0 0 0 !important; }

    .profile-userpic img {
        float: none;
        margin: 0 auto;
        width: 50%;
        height: 50%;
        -webkit-border-radius: 50% !important;
        -moz-border-radius: 50% !important;
        border-radius: 50% !important; }

    .profile-usertitle {
        text-align: center;
        margin-top: 20px; }

    .profile-usertitle-name {
        color: #5a7391;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 7px; }

    .profile-usertitle-job {
        text-transform: uppercase;
        color: #5b9bd1;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 7px; }

    .profile-userbuttons {
        text-align: center;
        margin-top: 10px; }

    .profile-userbuttons .btn {
        margin-right: 5px; }
    .profile-userbuttons .btn:last-child {
        margin-right: 0; }

    .profile-userbuttons button {
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 600;
        padding: 6px 15px; }

    .profile-usermenu {
        margin-top: 30px;
        padding-bottom: 20px; }

    .profile-usermenu ul li {
        border-bottom: 1px solid #f0f4f7; }

    .profile-usermenu ul li:last-child {
        border-bottom: none; }

    .profile-usermenu ul li a {
        color: #93a3b5;
        font-size: 16px;
        font-weight: 400; }

    .profile-usermenu ul li a i {
        margin-right: 8px;
        font-size: 16px; }

    .profile-usermenu ul li a:hover {
        background-color: #fafcfd;
        color: #5b9bd1; }

    .profile-usermenu ul li.active a {
        color: #5b9bd1;
        background-color: #f6f9fb;
        border-left: 2px solid #5b9bd1;
        margin-left: -2px; }

    .profile-stat {
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f4f7; }

    .profile-stat-title {
        color: #7f90a4;
        font-size: 25px;
        text-align: center; }

    .profile-stat-text {
        color: #5b9bd1;
        font-size: 11px;
        font-weight: 800;
        text-align: center; }

    .profile-desc-title {
        color: #7f90a4;
        font-size: 17px;
        font-weight: 600; }

    .profile-desc-text {
        color: #7e8c9e;
        font-size: 14px; }

    .profile-desc-link i {
        width: 22px;
        font-size: 19px;
        color: #abb6c4;
        margin-right: 5px; }

    .profile-desc-link a {
        font-size: 14px;
        font-weight: 600;
        color: #5b9bd1; }

    .profile-userabout{
        color: #4276A4;
        font: Sans 10pt;
        padding: 25px;
        text-transform: uppercase;
        text-align: center;
    }
    /* END PROFILE SIDEBAR */
    /* RESPONSIVE MODE */
    @media (max-width: 991px) {
        /* 991px */
        /* 991px */
        .profile-sidebar {
            float: none;
            width: 100% !important;
            margin: 0; }
        .profile-sidebar > .portlet {
            margin-bottom: 20px; }
        .profile-content {
            overflow: visible; } }

</style>
<script>
    export default{
        data(){
            return{
                user:{}
            }
        },
        props:['user_id'],
        ready(){
            window._this = this;
            _this.getUser();
        },
        methods:{

            getUser: function(){

                this.$http.get('/api/users/'+_this.user_id)
                    .then(function(response){
                        _this.user = response.json();
                    })
                    .catch(function(response){
                        toastr.error('Não foi possível conectar com a base.');
                    });

            }

        }
    }
</script>
