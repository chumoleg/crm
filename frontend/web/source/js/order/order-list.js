$(document).ready(function () {
    $(document).on('click', '.changeCurrentPostponedFilter', function () {
        var key = $(this).data('key');
        preLoaderShow();
        $.post('/order/ajax/index/change-postponed-filter', {key: key}, function () {
            window.location.reload();
        }, 'json');
    });
});