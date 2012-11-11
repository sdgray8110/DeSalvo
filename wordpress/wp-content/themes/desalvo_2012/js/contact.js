var contact = (function() {
    var self = {
        init: function() {
            self.setVars();
            self.attachHandlers();
        },

        setVars: function() {
            self.form = $('#contactUs')
        },

        attachHandlers: function() {
            $('#contactSubmit').on('click', function(e) {
                var formData = self.form.serializeObject();

                e.preventDefault();

                if (global.validate(formData,self.form)) {
                    self.submitForm(formData);
                }
            });
        },

        submitForm: function(data) {
            data.action = 'send_contact_email';

            jQuery.ajax({
                type: 'POST',
                url: global.pageData.ajaxurl,
                data: data,
                dataType: 'json'
            }).done(function(res) {
                $('#contact_fields').html(res.update_message);
            });
        }
    };

    return self;
})();

$(document).ready(function() {
    contact.init();
});