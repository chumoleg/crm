$(document).ready(function () {
    $(document).on('keyup', '#inputSearchProduct', function () {
        findByText($(this).val(), '.rowProduct');
    });
});