<!--[if lt IE 9]>
<script src="/dashboard/global/plugins/respond.min.js"></script>
<script src="/dashboard/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <script>
                window.Laravel = <?php echo json_encode([
                        'csrfToken' => csrf_token(),
                ]); ?>;
                window.Versato = <?php echo json_encode([
                        'brand_id' => session()->get('brand')->id
                ]); ?>;

                window.Scout = <?php echo json_encode([
                        'app_id' => env('ALGOLIA_APP_ID'),
//                        'secret' => env('ALGOLIA_SECRET'),
                        'search_key' => env('ALGOLIA_SEARCH_KEY'),
                        'prefix' => env('SCOUT_PREFIX')
                ]); ?>

                window.Maps = <?php echo json_encode([
                        'maps_key' => env('MAP_KEY'),
                        'maps_version' => env('MAP_VERSION'),
                ]); ?>
        </script>
        
        <!-- BEGIN CORE PLUGINS -->
        <script src="/js/app.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/dashboard/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="/dashboard/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        {{--<script src="/dashboard/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>--}}
        <script src="/dashboard/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="/dashboard/custom/notifications.js" type="text/javascript" charset="utf-8"></script>
    
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="/dashboard/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
        <script src="/dashboard/pages/scripts/form-wizard.js" type="text/javascript"></script>
        @yield('scripts')