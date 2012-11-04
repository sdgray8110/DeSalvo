var bikes = (function() {
    var self = {
        bikeGallery: $('#bikeGallery'),

        init: function() {
            self.attachHandlers();
        },

        attachHandlers: function() {
            self.bikeGallery.carousel();
            self.bikeGallery.imageGallery();
            $('#faq').find('.accordion').accordion();
        }
    };

    return self;
})();

bikes.init();