<script src="http://code.jquery.com/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="js/superbox.js"></script>
<script src="js/facebookFeed.js"></script>

<script type="text/javascript">
     $('#facebookContainer').fbFeed({
                userID: 193361797343222,
                token: '177579968987113|m1mxZVGLJOSN8DxjnyotKakgKOs'
        });
</script>
<script type="text/javascript">
    (function ($) {
        var settings = {
            targetEl : 'h4',
            activeClass : 'active',
            container : 'li',
            pane : '.slider',
            duration : 200
        };

    $.fn.accordion = function (options) {
        var options = $.extend({}, settings, options),
            root = $(this);

        initAccordion();

        function setActive(clicked, active) {
            removeActive(active);
            clicked.parents(options.container).addClass(options.activeClass);
        }

        function removeActive(active) {
            active.removeClass();
        }

        function accordiate(clicked, active) {
            var newPane = clicked.parents(options.container).find(options.pane),
                oldPane = active.find(options.pane);

            if (!newPane.parents(options.container).hasClass(options.activeClass)) {
                newPane.slideDown(options.duration);
                oldPane.slideUp(options.duration);

                setActive(clicked, active);
            } else {

                oldPane.slideUp(options.duration);
                removeActive(active);
            }

        }

        function initAccordion() {

            root.find(options.targetEl).click(function(e) {
                e.preventDefault();

                var clicked = $(this),
                    active = root.find('.' + options.activeClass);

                accordiate(clicked, active);
            });
        }
        
	};
})(jQuery);

$('.faq .accordion').accordion();

</script>