var buildkits = (function() {
    self = {
        init: function() {
            self.setVars();
            self.attachHandlers();
        },

        setVars: function() {
            self.brands = $('#brands');
        },

        attachHandlers: function() {
            var images = self.brands.find('img'),
                len = images.length;

            images.load(function() {
                self.brands.masonry({
                    gutterWidth: 20
                }).find('.hide').removeClass('hide');
            });
        }
    };

    return self;
})();

$(document).ready(function() {
    buildkits.init();
});