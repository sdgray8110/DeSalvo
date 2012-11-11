var global = (function() {
    var self = {
        init: function() {
            self.setPageData();
            self.attachHandlers();
        },

        attachHandlers: function() {
            $('.modalImage').fancybox();
        },

        setPageData: function() {
            var el = $('#pageData');

            if (el.length) {
                self.pageData = $.parseJSON(el.text());
            }
        }
    };

    return self;
})();

$(document).ready(function() {
    global.init();
});