$(document).ready(function () {
    setPopover();

    $(document).on('click', '.removeRowButton', function () {
        var obj = $(this).closest('.rowForRemove');
        if (obj.length) {
            obj.remove();

            if (typeof afterRemoveRow !== "undefined") {
                afterRemoveRow();
            }
        }
    });

    // $(document).on('click', '[data-toggle=modal]', function (e) {
    //     var $link = $(this);
    //     var modalId = $link.data('target');
    //     var load = $link.data('load');
    //     if (load != 1) {
    //         return;
    //     }
    //
    //     var $modal = $(modalId);
    //     $modal.find($link.data('load-target')).load($link.attr('href'), function () {
    //     });
    // });
    //
    // $(document).on('submit', '[data-modal-type=form] form', function (e) {
    //     var $form = $(this);
    //     var $modal = $form.parents('[data-modal-type=form]');
    //
    //     $.post($form.attr('action'), $form.serialize(), function (res) {
    //         $modal.modal('hide');
    //
    //         if ($form.has('pjax-update')) {
    //             var blockId = $form.data('pjax-update');
    //             $.pjax.reload({container: blockId, url: $(blockId).data('url'), replace: false});
    //         }
    //     });
    //
    //     return false;
    // });
});

function preLoaderShow() {
    var bodyH = $(window).height() / 2 - 90;
    $('body').css('opacity', 0.6);
    $('#bigPreLoader').css('padding-top', bodyH + 'px').show();
}

function preLoaderHide() {
    setTimeout(function () {
        var obj = $('body #bigPreLoader');
        obj.fadeOut('slow', function () {
            obj.hide();
            $('body').css('opacity', '');
        });
    }, 100);
}

jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function (arg) {
    return function (elem) {
        return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

function findByText(text, obj) {
    if (text) {
        $(obj).hide();
        $(obj + ':Contains("' + text + '")').show();
    } else {
        $(obj).show();
    }
}

function setPopover() {
    $('[data-toggle="popover"]').popover();
}

function checkJsonAnswer(data, reload) {
    if (data && data.status && data.status != 'error') {
        return true;
    }

    if (data && data.message) {
        alert(data.message);
    } else {
        alert('Ошибка при обработке ответа!!!');
    }

    if (reload) {
        window.location.reload();
    }

    return false;
}