$(document).ready(function () {
    $(document).on('submit', '#subscribeForm', function (e) {
        e.preventDefault();
        url = $(this).attr('action');
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            datatype: 'json',
            beforeSend: function () {
                $('#btnSubscribe').prop('disabled', true).val('Chargement... ');
            },
            success: function (json) {
                if (json.statuts == 0) {
                    toastr.success(json.mes, "succès");
                } else {
                    toastr.error(json.mes, "Echec");
                    $("#subscribeForm input").val("");
                }
            },
            complete: function () {
                $('#btnSubscribe').prop('disabled', false).val('souscrire');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
});