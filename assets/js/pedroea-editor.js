
(function($) {
    'use strict';
    
    $(window).on('elementor:init', function() {
        
        function addCustomCss(css, context) {
            
                if (!context || !context.model) {
                    return css;
                }
                
                let model = context.model;
                let settings = model.get('settings');
                
                if (!settings) {
                    return css;
                }
                
                let customCss = settings.get('pedro_custom_css');
                
                if (!customCss || customCss.trim() === '') {
                    return css;
                }
                
                let elementId = model.get('id');
                let selector = '.elementor-element.elementor-element-' + elementId;
                
                if ('document' === model.get('elType')) {
                    selector = 'body';
                }
                
                if (customCss) {
                    css += customCss.replace(/selector/g, selector);
                }
                
               return css;
                
        }
        
        if (typeof elementor !== 'undefined' && elementor.hooks) {
            elementor.hooks.addFilter('editor/style/styleText', addCustomCss);
        }
    });
    
})(jQuery);



