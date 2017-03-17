var ComponentsColorPickers = function() {


    var handleMiniColors = function() {
        $('#color-selector').minicolors({
                control: $(this).attr('data-control') || 'hue',
                defaultValue: $(this).attr('data-defaultValue') || '',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: $(this).attr('data-letterCase') || 'lowercase',
                opacity: $(this).attr('data-opacity'),
                position: $(this).attr('data-position') || 'bottom left',
                change: function(hex) {
                    if (!hex) return;
                    if (typeof console === 'object') {
                        console.log(hex);
                    }
                },
                theme: 'bootstrap'
            });

    }

    return {
        //main function to initiate the module
        init: function() {
            handleMiniColors();
        }
    };

}();

jQuery(document).ready(function() {    
   ComponentsColorPickers.init(); 
});