<template>
    <input type="text" class="dial">
</template>
<style scoped>

</style>
<script type="text/babel">
    export default{
        data(){
            return {
                value: 'hello vue',
                el: null,
            }
        },
        props: {
            slider_width: Number,
            slider_height: Number,
            slider_min: Number,
            slider_max: Number,
            slider_readonly: {
                Boolean,
                default: false
            },
            slider_bgcolor: String,
            slider_fgcolor: String,
            slider_cursor: Boolean,
            slider_thickness: Number,
            slider_value: {
                Number,
                twoWay: true
            },
            slider_prefix: {
                String,
                default : ''
            },
            slider_suffix: {
                String,
                default : ''
            },
        },
        ready(){
            var _Slider = this;
            _Slider.el = this.$el;
            if (_Slider.slider_width == undefined) {
                if (_Slider.slider_height == undefined) {
                    _Slider.slider_width = 100;
                } else {
                    _Slider.slider_width = _Slider.slider_height;
                }

            }
            if (_Slider.slider_height == undefined) {
                if (_Slider.slider_width == undefined) {
                    _Slider.slider_height = 100;
                } else {
                    _Slider.slider_height = _Slider.slider_width;
                }
            }

            this.initialize();

        },
        watch: {
            'slider_value': function (v) {
                var _Slider = this;
                $(_Slider.el)
                        .val(v)
                        .trigger('change');
                this.$dispatch('update')
            }
        },
        methods: {
            initialize(){
                var _Slider = this;
                var conf = this.buildConfig();
                $(_Slider.el).knob(conf);
                $(_Slider.el)
                        .val(_Slider.slider_value)
                        .trigger('change');
            },
            buildConfig(){
                var _Slider = this;
                var conf = {};
                if (this.slider_width) {
                    conf.width = this.slider_width;
                }
                if (this.slider_height) {
                    conf.height = this.slider_height;
                }
                if (this.slider_min) {
                    conf.min = this.slider_min;
                }
                if (this.slider_max) {
                    conf.max = this.slider_max;
                }
                if (this.slider_readonly) {
                    conf.readonly = this.slider_readonly;
                }
                if (this.slider_bgcolor) {
                    conf.bgColor = this.slider_bgcolor;
                }
                if (this.slider_fgcolor) {
                    conf.fgColor = this.slider_fgcolor;
                }
                if (this.slider_cursor) {
                    conf.cursor = this.slider_cursor;
                }
                if (this.slider_thickness) {
                    conf.thickness = true;
                }
                conf.format = function (value) {
                    return _Slider.slider_prefix + value + _Slider.slider_suffix;
                };
                conf.change = function (v) {
                    _Slider.slider_value = Math.round(v);
                };
                conf.skin = "tron";
                return conf;

            }
        }
    }
</script>
