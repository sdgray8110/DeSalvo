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
            setTimeout(function() {
                self.brands.masonry({
                    gutterWidth: 20
                }).find('.hide').removeClass('hide');
            },200);
        }
    };

    return self;
})();

$(document).ready(function() {
    buildkits.init();
});