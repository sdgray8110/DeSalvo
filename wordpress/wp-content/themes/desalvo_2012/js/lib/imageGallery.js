(function ($) {
    var settings = {
        bigImg : '.bigImg',
        thumbs : '.thumbnailGallery',
        imgPath : 'href',
        activeClass : 'active'
    };

    $.fn.imageGallery = function (options) {
        var options = $.extend({}, settings, options),
            container = $(this),
            bigImg = container.find(options.bigImg).find('img'),
            thumbs = container.find(options.thumbs + ' a');

        handleClicks();

        function handleClicks() {
            thumbs.click(function(e) {
                e.preventDefault();
                var root = $(this),
                    rootContainer = root.parents('li');

                if (!rootContainer.hasClass(options.activeClass)) {
                    var newImg = $(this).attr(options.imgPath);
                    switchImages(newImg, root);
                }
            });
        }

        function switchImages(newImg, root) {
            setActive(root);
            transitionImages(newImg);
        }

        function setActive(root) {
            $(options.thumbs).find('.' + options.activeClass).removeClass(options.activeClass);
            root.parents('li').addClass(options.activeClass);
        }

        function transitionImages(newImg) {
            bigImg.fadeOut(350, function() {
                bigImg.attr('src', newImg);
                bigImg.load(function() {
                    bigImg.fadeIn(350);    
                });
            })
        }
	};
})(jQuery);