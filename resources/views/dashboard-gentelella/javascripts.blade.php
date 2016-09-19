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
        </script>
        <!-- BEGIN CORE PLUGINS -->
        <script src="/js/app.js" type="text/javascript"></script>
        <script src="/js/custom.js" type="text/javascript"></script>
        <script src="/js/helper.js" type="text/javascript"></script>
        {{--<script src="/dashboard/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>--}}
        <!-- END CORE PLUGINS -->

        @yield('scripts')
