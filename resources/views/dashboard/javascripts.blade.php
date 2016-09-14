<!--[if lt IE 9]>
<script src="/dashboard/global/plugins/respond.min.js"></script>
<script src="/dashboard/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
</script>
        <!-- BEGIN CORE PLUGINS -->
        <script src="/js/app.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue-strap/1.1.0/vue-strap.min.js"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/dashboard/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
        <script src="/dashboard/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="/dashboard/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="/dashboard/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="/dashboard/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="/dashboard/custom/notifications.js" type="text/javascript" charset="utf-8"></script>
        <script src="/dashboard/global/scripts/moment.min.js"></script>

        <script>
                window.Laravel = <?php echo json_encode([
                        'csrfToken' => csrf_token(),
                ]); ?>
        </script>

        <!-- END THEME LAYOUT SCRIPTS -->no
        @yield('scripts')
