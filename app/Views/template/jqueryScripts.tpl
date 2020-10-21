{* SMARTY *}

<script>
    $('.ajaxForm').submit(function (e) {
        e.preventDefault();
        const form = $(this);
        $("#" + form.data('loader')).show();
        AjaxLoading(form.data("loader"));
        AjaxPost(form.data("url"), form.serialize(), function (data) {
            let msg = data['message'];
            if (data['state'] == 'success') {
                msg = "<div class='message alert alert-success alert-dismissible'>" + data['message'] + "</div>";

                form.trigger('success', [data['data']]);

                if (form.data("url").indexOf('signinConfirm') > 0)
                    setTimeout(function (e) {
                        location.reload();
                    }, 2000);
            }
            if (data['state'] == 'dead')
                location.reload();
            $("#" + form.data("loader")).html(msg);

            setTimeout(function (e) {
                $("#" + form.data("loader")).hide();
            }, 20000);
            return false;
        });
        RemoveAjaxLoader(form.data("loader"));
        return false;
    });


    $(function () {
        $('.languageSwitch').on('click', function () {
            let langKey = $(this).data("key");
            $.cookie('currentLanguage', langKey);
            window.location.reload();
            return false;
        });

        'use strict';
        $.cookieBar({
            fixed: true
        });
    });
</script>