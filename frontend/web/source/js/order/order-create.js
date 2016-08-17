$(document).ready(function () {
    $(document).on('click', '.addProductToOrder', function () {
        var link = $(this);
        var modal = link.closest('div.modal');
        var params = {
            productPriceId: link.data('id'),
            counter: parseInt($('.rowCounter:last').val()) + 1
        };

        $.post('/call/order/ajax/order-create/add-product', params, function (result) {
            if (!checkJsonAnswer(result)) {
                return;
            }

            $('#orderProducts').append(result.response);
            $('.productDataCheckerInput').val('1').trigger('change');
            modal.modal('hide');
        }, 'json');
    });
});

function afterRemoveRow() {
    var val = '';
    if ($('#orderProducts').find('.rowForRemove').length > 0) {
        val = '1'
    }

    $('.productDataCheckerInput').val(val).trigger('change');
}