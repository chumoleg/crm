$(document).ready(function () {
    $(document).on('click', '.pjax-wrapper .pjax-button', function (e) {
        var url = $(this).attr('href');
        var containerId = $(this).closest('.pjax-wrapper').attr('id');
        var confirmMsg = $(this).data('confirm-msg');
        if (confirmMsg) {
            if (!confirm(confirmMsg)) {
                return false;
            }
        }

        $.post(url, function () {
            $.pjax.reload('#' + containerId);
        });

        return false;
    });
});
