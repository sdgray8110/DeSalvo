fbPostsGlobal = fbPostsGlobal || {};
fbPostsGlobal.extensions.push('admin');

jQuery.extend(fbPostsGlobal, {
    admin: (function() {
        var self = {
            setVars: function() {
                var data = {
                    container: jQuery('#fbFeeds'),
                    feedFormContainer: jQuery('#feedFormContainer')
                };

                jQuery.extend(self,data);
            },

            init: function() {
                self.setVars();
                self.attachHandlers();
                self.extendValidationMessages();
                self.renderFeedsTable(fbPostsGlobal.pageData);
            },

            attachHandlers: function() {
                self.container.on('click', '.verifyFeed', function(e) {
                    self.verifyFeed(e);
                });

                self.container.on('click', '.saveFeed', function(e) {
                    self.saveFeed(e);
                });

                self.container.on('click', '.editFeed, .addAnother', function(e) {
                    self.editFeed(jQuery(this),e);
                });

                self.container.on('click', '.deleteFeed', function(e) {
                    self.editFeed(jQuery(this),e);
                });
            },

            verifyFeed: function(e) {
                var button = jQuery(e.target),
                    form = button.parents('form'),
                    data = form.serializeObject(),
                    valid = fbPostsGlobal.validation.validate(data,form);

                e.preventDefault();

                if (valid) {
                    self.verifyAppAjax(data,form);
                }
            },

            saveFeed: function(e) {
                var button = jQuery(e.target),
                    form = button.parents('form'),
                    data = form.serializeObject();

                e.preventDefault();

                self.saveFeedAjax(data,form);
            },

            editFeed: function(el,e) {
                var data = self.rowData(el);

                fbPostsGlobal.applyTemplate({
                    data: data,
                    container: self.feedFormContainer,
                    templateEl: jQuery('#feedFormTemplate')
                });

                e.preventDefault();
            },

            deleteFeed: function(el,e) {
                var data = self.rowData(el);

                e.preventDefault();
            },

            rowData: function(el) {
                var row = el.parents('tr'),
                    attributes = {
                        'data-feedname': 'feedName',
                        'data-fbuserid': 'fbUserID',
                        'data-fbappid': 'fbAppID',
                        'data-fbsecret': 'fbSecret',
                        'data-fblimit': 'fbLimit',
                        'data-fbfeed': 'fbFeed',
                        'data-fbOwnerOnly': 'fbOwnerOnly',
                        'data-fbPhotosOnly': 'fbPhotosOnly'
                    },
                    data = {};

                for (var k in attributes) {
                    data[attributes[k]] = row.attr(k);
                }

                return data;
            },

            renderFeedsTable: function(data) {
                fbPostsGlobal.applyTemplate({
                    data: data,
                    container: jQuery('#feedTableContainer'),
                    templateEl: jQuery('#facebookTableTemplate')
                });
            },

            verifyAppAjax: function(data,form) {
                data.action = 'verify_app';

                jQuery.ajax({
                    'type': 'POST',
                    'data': data,
                    'dataType': 'JSON',
                    'url': ajaxurl,
                    'success': function(res) {
                        var template = self.isError(res) ? 'facebookErrorTemplate' : 'recentPostTemplate';

                        fbPostsGlobal.applyTemplate({
                            data: res,
                            container: form.find('.verificationContent'),
                            templateEl: jQuery('#' + template)
                        });
                    }
                });
            },

            saveFeedAjax: function(data,form) {
                data.action = 'save_new_feed';

                jQuery.ajax({
                    'type': 'POST',
                    'data': data,
                    'dataType': 'JSON',
                    'url': ajaxurl,
                    'success': function(res) {
                        self.feedFormContainer.empty();
                        self.renderFeedsTable(res);
                    }
                });
            },

            isError: function(res) {
                var error = false,
                    accept = ['object','string'];

                if (!jQuery.inArray(typeof(res),accept) >= 0) {
                    if (typeof(res.error) !== 'undefined') {
                        error = true;
                    }
                } else {
                    error = true;
                }

                return error;
            },

            extendValidationMessages: function() {
                var messages = {
                    'fbSecret': 'Please Enter Your Facebook App Secret',
                    'fbAppID': 'Please Enter Your Facebook App ID',
                    'feedName': 'Please Enter Your Facebook Application Name',
                    'fbUserID': 'Please Enter Your Facebook User ID'
                };

                jQuery.extend(fbPostsGlobal.validation.validationMessages,messages);
            }
        };

        return self;
    })(window)
});