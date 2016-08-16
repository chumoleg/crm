$(document).ready(function () {
    $(document).on('change', '.setOperatorForOrder', function () {
        var params = {
            orderId: $(this).data('order-id'),
            operator: $(this).val()
        };

        $.post('/order/ajax/order/set-current-operator', params, function (result) {
            checkJsonAnswer(result);
        }, 'json');
    });
});