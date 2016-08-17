$(document).ready(function () {
    $(document).on("submit", 'form#modalInnerForm', function (e) {
        e.preventDefault();
        var form = $(this);
        var modal = form.closest('div.modal');

        var counter = parseInt($('.rowCounter:last').val());
        if (!counter) {
            counter = 0;
        }

        var params = {
            formData: form.serialize(),
            counter: (counter + 1)
        };

        $.post(form.attr('action'), params, function (result) {
            if (!checkJsonAnswer(result)) {
                return;
            }

            $('#modalFormAppendResult').append(result.response);
            modal.modal('hide');
        }, 'json');
    });
});