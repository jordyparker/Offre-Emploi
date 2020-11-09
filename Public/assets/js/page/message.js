$(document).ready(function(){
    $(document).on('click','#messageModal', function (e) {
        e.preventDefault();
        $('#description').val('');
        var idC = $(this).data('idc'),
            idO  = $(this).data('ido');
        $('#idO').val(idO);
        $('#idC').val(idC);
        $('#modalMessage').modal('show');
    });
    $(document).on('submit', '#addMsg', function (e) {
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
                $('#btncmp').text('Chargement ...').prop('disabled', true);
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
                $('#btnSubmit').text('Envoyez').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
});