(function ($) {
    var settings = {
        carouselClass: 'carousel',
        carouselContainer: 'carouselContainer',
        viewDelimit: 'view',
        duration: 300
    };

    $.fn.carousel = function (options) {
        var options = $.extend({}, settings, options),
            root = $(this),
            container = root.find('.' + options.carouselContainer),
            carousel = root.find('.' + options.carouselClass),
            carouselUL = carousel.find('ul').eq(0),
            view = parseInt(carousel.attr('class').split(options.viewDelimit)[1].split(' ')[0]),
            dims = carouselDims();

        initCarousel();

        function initCarousel() {
            carouselUL.css({'width': dims.carouselWidth, 'left': 0});
            createPagers();
            handleClicks();
        }

        function handleClicks() {
            container.find('.next, .prev').live('click', function(e) {
                e.preventDefault();

                var root = $(this),
                    direction = root.attr('class');

                if (!root.hasClass('disabled')) {
                    slideCarousel(direction);
                }
            });
        }

        function slideCarousel(direction) {
            var animObj = animation(direction);

            carouselUL.animate(animObj, options.duration, function() {
                disablePagers();
            });
        }

        function createPagers() {
            if (carouselUL.find('li').length > view) {
                var next = '<a class="next" href ="#">&gt;</a>',
                    prev = '<a class="prev" href ="#">&lt;</a>';

                container.append(prev + next);

                disablePagers();
            }
        }

        function carouselDims() {
            dims = {
                pageWidth: carousel.width(),
                items: carousel.find('li').length
            };

            dims.pages = Math.ceil(dims.items/view);
            dims.carouselWidth = dims.pageWidth * dims.pages;

            return dims;
        }

        function animation(direction) {
            direction == 'prev' ? offset = parseInt('+' + dims.pageWidth) : offset = parseInt('-' + dims.pageWidth);

            var curPosition = parseInt(carouselPosition()),
                offset = curPosition + offset,
                animObj = {
                    left: offset
                };

            return animObj;
        }

        function carouselPosition() {
            return carouselUL.position().left;
        }

        function disablePagers() {
            var curPosition = carouselPosition(),
                max = parseInt('-' + (dims.carouselWidth - dims.pageWidth - 20)),
                next = container.find('.next'),
                prev = container.find('.prev');

            if (curPosition >= 0) {
                next.removeClass('disabled');
                prev.addClass('disabled');
            } else if (curPosition <= max) {
                prev.removeClass('disabled');
                next.addClass('disabled');
            } else {
                prev.removeClass('disabled');
                next.removeClass('disabled');
            }
        }

	};
})(jQuery);