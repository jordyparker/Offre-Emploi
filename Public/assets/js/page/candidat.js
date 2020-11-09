$(document).ready(function(){
    $(document).on('submit', '#formC', function (e) {
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
                $('#btnC').text('Chargement ...').prop('disabled', true);
            },
            success: function (json) {
                if(json.statuts == 0) {
                    toastr.success(json.mes,'Success!');
                    // window.location.reload();
                }else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('#btnC').text('Créer mon compte').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $('#file').fileinput({
        showCaption : false,
        showBrowse : true,
        showPreview : true,
        showRemove: true,
        showUpload: false,
        showUploadStats: true,
        showCancel: false,
        showPause: null,
        showCole: true,
    });
    $('.date').datepicker();
    $('.description').ckeditor(function(){},
        {
            customConfig:'../../assets/plugins/ckeditor_config.js'
        });
});