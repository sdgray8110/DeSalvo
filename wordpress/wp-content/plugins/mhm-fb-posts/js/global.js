var fbPostsGlobal = (function() {
    var self = {
        extensions: [],

        init: function() {
            self.objectSerializer();
            self.setPageData();
            self.initialize_extensions();
        },

        initialize_extensions: function() {
            for (var i = 0; i < self.extensions.length; i++) {
                var extension = self.extensions[i];

                if (typeof(self[extension]) !== 'undefined') {
                    self[extension].init();
                }
            }
        },

        objectSerializer: function() {
            jQuery.fn.serializeObject = function() {
                var o = {};
                var a = this.serializeArray();
                jQuery.each(a, function() {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };
        },

        setPageData: function() {
            self.pageData = jQuery.parseJSON(jQuery('#pageData').text());
        },

        // Renders JSON data into a specified container.
        applyTemplate: function (options) {
            var settings = {
                    data: {},
                    container: [],
                    templateEl: [],
                    append: false,
                    callback: function () { }
                },
                options = jQuery.extend({}, settings, options);

            template = options.templateEl.tmpl(options.data);


            if (!options.append) {
                options.container.html(template);
            } else {
                options.container.append(template);
            }

            options.callback();
        },

        isSelected: function(num,val) {
            if (num == val) {
                return 'selected="selected"';
            }

            return '';
        },

        isChecked: function(num,val) {
            if (num == val) {
                return 'checked="checked"';
            }

            return '';
        }
    };

    return self;
})(window);

jQuery(document).ready(function() {
    fbPostsGlobal.init();
});