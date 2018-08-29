(function ($) {
    $.mergerorder_settings = {
        options: {},
        init: function (options) {
            this.options = options;
            this.initButtons();
            return this;
        },
        initButtons: function () {
            $('#ibutton-status').iButton({
                labelOn: "Вкл", labelOff: "Выкл"
            }).change(function () {
                var self = $(this);
                var enabled = self.is(':checked');
                if (enabled) {
                    self.closest('.field-group').siblings().show(200);
                } else {
                    self.closest('.field-group').siblings().hide(200);
                }
                var f = $("#plugins-settings-form");
                $.post(f.attr('action'), f.serialize());
            });
            $('.ibutton').iButton({
                labelOn: "Вкл",
                labelOff: "Выкл",
                className: 'mini'
            });

            $('#ibutton-email-notification').iButton({
                labelOn: "", labelOff: "", className: 'mini'
            }).change(function () {
                var self = $(this);
                var enabled = self.is(':checked');
                if (enabled) {
                    $('.email-notification').show(200);
                } else {
                    $('.email-notification').hide(200);
                }
            });

            CodeMirror.fromTextArea(document.getElementById('sf-template'), {
                mode: "text/html",
                tabMode: "indent",
                height: "dynamic",
                lineWrapping: true,
                onChange: function (c) {
                    c.save();
                }
            });
        }
    };
})(jQuery);
