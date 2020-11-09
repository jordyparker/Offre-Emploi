$(document).ready(function(){
    $(document).on('submit', '#formPost', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('#btnPost').text('Chargement ...').prop('disabled', true);
            },
            success: function (json) {
                if(json.statuts == 0) {
                    toastr.success(json.mes,'Success!');
                    window.location.reload();
                }else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('#btnPost').text('Poster').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $('#description').ckeditor(function(){},
        {
            customConfig:'../assets/plugins/ckeditor.js'
        });
    $('#delais').datepicker();
});