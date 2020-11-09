$(document).ready(function(){
    $(document).on('click','#updateParams', function (e) {
        e.preventDefault();
        $('#modalParams').modal('show');
    });
    $(document).on('submit', '#formParams', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        console.log(data);
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: false,
            processData: false,
            datatype: 'json',
            beforeSend: function () {
                $('#btnU').text('Chargement ...').prop('disabled', true);
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
                $('#btnU').text('MODIFIER').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
});