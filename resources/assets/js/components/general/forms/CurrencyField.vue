<script>
    Vue.directive('input-mask', {
        params: ['mask'],

        bind: function() {
            $(this.el).inputmask({
                mask: this.params.mask
            });

        },
    });

</script>