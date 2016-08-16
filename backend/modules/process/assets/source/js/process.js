var stages = {};

$(document).ready(function () {
    _updateActionSelect();

    $(document).on('beforeSubmit', 'form#dynamic-form', function (event) {
        var stagesList = [];
        var error = false;
        $.each($('.stageSelect'), function (k) {
            var val = $(this).val();
            if (val) {
                if ($.inArray(val, stagesList) == -1) {
                    stagesList.push($(this).val());
                } else {
                    error = 'Статус "' + $(this).find('option:selected').text() + '" дублируется в списке';
                    return false;
                }
            }
        });

        if (!error && $('.firstStageCheckBox:checked').length == 0) {
            error = 'Не выбран начальный статус! Проставьте чекбокс!';
        }

        if (error) {
            alert(error);
            return false;
        }

        return true;
    });

    $(".dynamicFormStage").on("beforeDelete", function (e, item) {
        if (!confirm("Вы уверены, что хотите удалить данный статус из списка?")) {
            return false;
        }

        return true;

    }).on("afterDelete", function (e, item) {
        _updateActionSelect();

    });

    $(document).on("change", '.stageSelect', function () {
        _updateActionSelect();
    });

    $(document).on("change", '.firstStageCheckBox', function () {
        var obj = $(this);
        if (obj.is(':checked')) {
            $('.firstStageCheckBox').prop('checked', false);
            obj.prop('checked', true);
        }
    });
});

function actionAfterInsert(widgetOptions) {
    if (widgetOptions.widgetContainer == 'dynamicFormAction') {
        _updateActionSelect();

    } else if (widgetOptions.widgetContainer == 'dynamicFormStage') {
        $('.stage-item:last .firstStageCheckBox').prop('checked', false);
        _updateActionSelect();
    }
}

function actionLimitReached(widgetOptions) {
    if (widgetOptions.widgetContainer == 'dynamicFormAction') {
        alert("Больше, чем есть действий в списке, нельзя добавить!");
    } else if (widgetOptions.widgetContainer == 'dynamicFormStage') {
        alert("Больше, чем есть статусов в списке, нельзя добавить!");
    }
}

function _updateActionSelect() {
    stages = {};
    $.each($('.stageSelect'), function (k) {
        if ($(this).val()) {
            stages[k] = {
                id: $(this).val(),
                name: $(this).find('option:selected').text()
            };
        }
    });

    $.each($('.followToStageSelect'), function (k) {
        var selectObj = $(this);
        var val = selectObj.val();
        selectObj.find('option').remove();
        selectObj.append('<option value="">Без перехода</option>');

        var stageSelected = $(this).closest('.stage-item').find('.stageSelect').val();
        $.each(stages, function (id, item) {
            if (item.id && item.id != stageSelected) {
                var selected = '';
                if (item.id == val) {
                    selected = 'selected';
                }

                selectObj.append('<option value="' + item.id + '" ' + selected + '>' + item.name + '</option>');
            }
        });

        var selectedByRow = $(this).closest('.action-item').data('follow-to');
        if (selectedByRow) {
            selectObj.val(selectedByRow);
        }
    });
}