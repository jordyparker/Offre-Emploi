$(document).ready(function(){
    $(document).on('click','#postuler', function (e) {
        e.preventDefault();
        var idC = $(this).data('idc'),
            idO = $(this).data('ido');

        console.log(idC+''+idO);
        $('#idC').val(idC);
        $('#idO').val(idO);
        $('#modalPost').modal('show');
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
                $('#btncmp').text('Postuler').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
});