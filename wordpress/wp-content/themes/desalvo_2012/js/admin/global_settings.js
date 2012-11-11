var global_settings = (function() {
    var self = {

        setVars: function() {
            self.form = jQuery('#globalSettings');
        },

        init: function() {
            self.setVars();
            self.setupValidation();
            self.attachHandlers();
        },

        attachHandlers: function() {
            jQuery('#save_global_settings').on('click', function(e) {
                e.preventDefault();
                var data = self.form.serializeObject();

                if (global.validate(data,self.form)) {
                    self.submitForm(data);
                }

            });
        },

        submitForm: function(data) {
            data.action = 'update_global_settings';

            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                dataType: 'json'
            }).done(function(res) {
                jQuery('#updateMessage').text(res.message);
            });
        },

        setupValidation: function() {
            jQuery.extend(global.validationMessages, {
                'primary_email': 'Please enter a valid primary email address',
                'webmaster_email': 'Please enter a valid Webmaster email address'
            })
        }
    };

    return self;
})();

jQuery(document).ready(function() {
    global_settings.init();
});