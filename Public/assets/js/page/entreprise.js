$(document).ready(function(){
    $('#date').datepicker();
    $('#delais').datepicker();
    $(document).on('submit', '#formE', function (e) {
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
                $('#btnE').text('Chargement ...').prop('disabled', true);
            },
            success: function (json) {
                if (json.statuts == 0) {
                    toastr.success(json.mes,'Success!');
                    window.location.reload();
                } else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('#btnE').text('Créer mon compte').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $('#file').fileinput({
        showCaption : true,
        showBrowse : true,
        showPreview : true,
        showRemove: true,
        showUpload: true,
        showUploadStats: true,
        showCancel: null,
        showPause: null,
        showCole: true,
    });
    $('#description').ckeditor(function(){},
        {
            customConfig:'../assets/plugins/ckeditor.js'
        });
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
                    // window.location.reload();
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
});