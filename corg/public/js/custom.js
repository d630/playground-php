$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
});

$("#checkAll").click(function () {
    $(".form-check-input").prop('checked', $(this).prop('checked'));
});

$('#inputGroupFile').on('change',function(){
    var fileName = $(this).val().replace("C:\\fakepath\\", "");
    $(this).next('.custom-file-label').html(fileName);
});
