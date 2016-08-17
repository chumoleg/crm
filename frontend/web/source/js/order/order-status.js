$(document).ready(function () {
    var orderId = $('#orderId').val();

    $(document).on('click', '.stageActionButton', function () {
        var params = {
            orderId: orderId,
            action: $(this).data('action')
        };

        preLoaderShow();
        $.post('/call/order/ajax/order-status/action', params, function (result) {
            if (!checkJsonAnswer(result)) {
                preLoaderHide();
                return;
            }

            if (result.response.reload) {
                window.location.reload();
            }

            if (result.response.modal) {
                showHtmlModal(result.response.modal.body, result.response.modal.title);
            }

            preLoaderHide();
        }, 'json');
    });

    $(document).on('click', '.changeStatusButton', function () {
        var holdTime = null;
        if ($(this).closest('.modal-body').find('.holdTimeInput').length > 0) {
            holdTime = $(this).closest('.modal-body').find('.holdTimeInput').val();

            if (!holdTime) {
                alert('Выберите дату и время!');
                return false;
            }
        }

        var params = {
            orderId: orderId,
            action: $(this).data('action'),
            reason: $(this).data('reason'),
            holdTime: holdTime
        };

        preLoaderShow();
        $.post('/call/order/ajax/order-status/change', params, function (result) {
            if (!checkJsonAnswer(result)) {
                preLoaderHide();
                return;
            }

            if (result.response.reload) {
                window.location.reload();
            }

            preLoaderHide();
        }, 'json');
    });
});