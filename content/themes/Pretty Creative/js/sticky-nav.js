jQuery(document).ready(function($) {
        var $filter = $('.nav-primary');
        var $filterSpacer = $('<div />', {
                "class": "filter-drop-spacer",
                "height": $filter.outerHeight()
        });
 
 
        if ($filter.size())
        {
                $(window).scroll(function ()
                {
                        if (!$filter.hasClass('fix') && $(window).scrollTop() > $filter.offset().top && window.innerWidth > 500)
                        {
                                $filter.before($filterSpacer);
                                $filter.addClass("fix");
                        }
                        else if ($filter.hasClass('fix')  && $(window).scrollTop() < $filterSpacer.offset().top)
                        {
                                $filter.removeClass("fix");
                                $filterSpacer.remove();
                        }
                });
        }
 
});