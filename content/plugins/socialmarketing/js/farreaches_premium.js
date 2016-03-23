jQuery(function($){
    
    $.fn.getFeatureName = function() {
        var className = $(this).attr('class');
        if (!className || className.indexOf('fr-feature-') > 0) {
            return $(this).parent('[class*=fr-feature-]').getFeatureName();
        }
        var featureName = className.substring(className.indexOf('fr-feature-') + 11).split(" ")[0];
        return featureName;
    };
    
     // [name] is the name of the event "click", "mouseover", .. 
     // same as you'd pass it to bind()
     // [fn] is the handler function
     $.fn.bindFirst = function(name, fn) {
         // bind as you normally would
         // don't want to miss out on any jQuery magic
         this.on(name, fn);
    
         // Thanks to a comment by @Martin, adding support for
         // namespaced events too.
         this.each(function() {
             var handlers = $._data(this, 'events')[name.split('.')[0]];
             console.log(handlers);
             // take out the handler we just inserted from the end
             var handler = handlers.pop();
             // move it at the beginning
             handlers.splice(0, 0, handler);
         });
     };
    
    $('[class*=fr-feature-]').each(function() {
        var featureName = $(this).getFeatureName();
        if ($('.fr-paid-' + featureName).length == 0) {
            $(this).find('button[data-publish-topic], a[data-publish-topic]').off('.farreaches');
            $(this).onclick = null;
        }
    });
    
    $('[class*=fr-feature-], [class*=fr-feature-] *').bindFirst('click', function(clickEvent) {
        var featureName = $(this).getFeatureName();
        if ($('.fr-paid-' + featureName).length == 0) {
            clickEvent.preventDefault();
            clickEvent.stopImmediatePropagation();
            $($('#farreaches-tmpl-premium').render(FARREACHES.config)).modal({
                overlayClose:true,
                closeHTML:'x',
                minWidth:'350px',
                maxWidth:'350px',
                minHeight:'110px',
                maxHeight:'110px'
            });
        }
    });
    
    $(document).on('click', '#fr-modal-cancel', function() {
        $.modal.close();
    }); 
});