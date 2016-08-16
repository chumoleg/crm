$(document).ready(function () {
    $(document).on('click', '.showModalButton', function () {
        showLoadModal(
            $(this).data('url'),
            $(this).data('title'),
            $(this).data('target'),
            $(this).data('size')
        );
    });
});

function showLoadModal(loadUrl, title, modalId, size) {
    _showModal(loadUrl, null, title, modalId, size)
}

function showHtmlModal(html, title, modalId, size) {
    _showModal(null, html, title, modalId, size)
}

function _showModal(loadUrl, html, title, modalId, size) {
    if (!modalId || !$(modalId).length) {
        modalId = '#modalForm';
    }

    var modal = $(modalId);
    var modalContent = modal.find('.modal-body');
    var modalHeader = modal.find('.modal-header #modalHeaderTitle');
    if (!modal.data('bs.modal').isShown) {
        modal.modal('show');

        if (size) {
            modal.find('.modal-dialog').addClass(size);
        }
    }

    if (loadUrl) {
        modalContent.load(loadUrl);
    } else {
        modalContent.html(html);
    }

    modalHeader.html('<h3>' + title + '</h3>');
}