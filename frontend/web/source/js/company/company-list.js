$(document).ready(function () {
    $(document).on('click', '#changeCurrentOperatorChecked', function () {
        var params = {
            operator: $('#currentOperatorList').val(),
            items: $('#companyGrid').yiiGridView('getSelectedRows')
        };

        if (!confirm('Вы уверены в выполнении данного действия?')) {
            return false;
        }

        preLoaderShow();
        $.post('/company/ajax/change-operator-by-items', params, function (answer) {
            if (answer.error) {
                preLoaderHide();
                alert(answer.error);
                return false;
            }

            window.location.reload();
        }, 'json');
    });

    $(document).on('click', '#changeCurrentOperatorFromTo', function () {
        var params = {
            fromOperator: $('#currentOperatorFrom').val(),
            toOperator: $('#currentOperatorTo').val()
        };

        if (!confirm('Вы уверены в выполнении данного действия?')) {
            return false;
        }

        preLoaderShow();
        $.post('/company/ajax/change-operator-from-to', params, function (answer) {
            if (answer.error) {
                preLoaderHide();
                alert(answer.error);
                return false;
            }

            window.location.reload();
        }, 'json');
    });
});