$(document).ready(function () {
    var orderId = $('#orderId').val();
    scrollDownComments();
    scrollDownHistory();

    $(document).on('change', '#fieldTextComment', function () {
        var obj = $(this);
        $.post('/order/ajax/order/add-comment', {orderId: orderId, text: obj.val()}, function (result) {
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

    $(document).on('submit', '#companyContactForm', function () {
        var modal = $(this).closest('div.modal');
        var params = {
            orderId: orderId,
            formData: $(this).serialize()
        };

        preLoaderShow();
        $.post('/order/ajax/order/add-company-contact', params, function (answer) {
            $.pjax.reload('#companyContactBlock');
            _addComment(answer.response.commentList);
            preLoaderHide();
            modal.modal('hide');
        }, 'json');

        return false;
    });

    $(document).on('click', '.addProductToOrder', function () {
        var link = $(this);
        var modal = link.closest('div.modal');
        var params = {
            orderId: orderId,
            productPriceId: link.data('id')
        };

        preLoaderShow();
        $.post('/order/ajax/order-product/add', params, function (result) {
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
        $.post('/order/ajax/order-product/remove', params, function (result) {
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
        $.post('/order/ajax/order/call', {orderId: orderId, contactId: $(this).data('contact')}, function (result) {
            preLoaderHide();
            if (checkJsonAnswer(result)) {
                _addComment(result.response);
            }
        }, 'json');
    });

    $(document).on('click', '.sendSmsOrder', function () {
        $.post('/order/ajax/order/send-sms', {orderId: orderId}, function (result) {
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