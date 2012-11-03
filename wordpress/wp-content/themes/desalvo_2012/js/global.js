var global = (function() {
    var self = {
        init: function() {
            self.attachHandlers();
        },

        attachHandlers: function() {
            $('.modalImage').fancybox();
        }
    };

    return self;
})();

$(document).ready(function() {
    global.init();
});