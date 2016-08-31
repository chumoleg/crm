$(document).ready(function () {
    var orderId = $('#orderId').val();
    scrollDownComments();
    scrollDownHistory();

    $(document).on('change', '#regionSelect', function () {
        $.post('/call/order/ajax/index/area-list', {region: $(this).val()}, function (result) {
            if (!checkJsonAnswer(result)) {
                return;
            }

            $('#areaSelect').find('option').remove();
            $.each(result.response, function (key, value) {
                $('#areaSelect').append($('<option></option>').attr('value', key).text(value));
            });
        }, 'json');
    });

    $(document).on('change', '#fieldTextComment', function () {
        var obj = $(this);
        $.post('/call/order/ajax/order/add-comment', {orderId: orderId, text: obj.val()}, function (result) {
            if (checkJsonAnswer(result)) {
                _addComment(result.response);
            }

            obj.val('');
        }, 'json');
    });

    function _addComment(commentList) {
        $('#orderCommentBlock').html(commentList);
        scrollDownComments();
    }

    function _changeOrderField() {
        var params = {
            orderId: orderId,
            fieldName: $(this).attr('name'),
            value: $(this).val()
        };

        preLoaderShow();
        $.post('/call/order/ajax/order/update', params, function (result) {
            preLoaderHide();
            if (!checkJsonAnswer(result)) {
                return;
            }

            _addComment(result.response);
        }, 'json');
    }

    $(document).on('change', '#orderForm #areaSelect, #orderForm #typeDelivery', function () {
        if ($(this).val() && $(this).val() != 0) {
            _changeOrderField.call(this);
        }
    });

    $(document).on('change', '#orderForm input', function () {
        _changeOrderField.call(this);
    });

    $(document).on('click', '.addProductToOrder', function () {
        var link = $(this);
        var modal = link.closest('div.modal');
        var params = {
            orderId: orderId,
            productPriceId: link.data('id')
        };

        preLoaderShow();
        $.post('/call/order/ajax/order-product/add', params, function (result) {
            if (_changeProductList(result)) {
                modal.modal('hide');
            }
        }, 'json');
    });

    $(document).on('click', '.removeOrderProduct', function () {
        var params = {
            orderId: orderId,
            orderProductId: $(this).closest('tr').data('id')
        };

        preLoaderShow();
        $.post('/call/order/ajax/order-product/remove', params, function (result) {
            _changeProductList(result);
        }, 'json');
    });

    function _changeProductList(result) {
        preLoaderHide();
        if (!checkJsonAnswer(result)) {
            return false;
        }

        $('#orderProductsBlock').html(result.response.productList);
        _addComment(result.response.commentList);

        return true;
    }

    $(document).on('click', '.callOrder', function () {
        preLoaderShow();
        $.post('/call/order/ajax/order/call', {orderId: orderId}, function (result) {
            preLoaderHide();
            if (checkJsonAnswer(result)) {
                _addComment(result.response);
            }
        }, 'json');
    });

    $(document).on('click', '.sendSmsOrder', function () {
        $.post('/call/order/ajax/order/send-sms', {orderId: orderId}, function (result) {
            if (checkJsonAnswer(result)) {
                _addComment(result.response);
            }
        }, 'json');
    });
});

function scrollDownComments() {
    var history = $('#orderCommentBlock');
    if (history.length == 0) {
        return;
    }

    history.scrollTop(history.find('table').height());
}


function scrollDownHistory() {
    var history = $('.stageHistoryBlock');
    if (history.length == 0) {
        return;
    }

    history.scrollTop(history.find('.innerStageHistoryBlock').height());
}