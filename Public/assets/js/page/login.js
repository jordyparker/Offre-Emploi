$(document).ready(function () {
    $(document).on('submit', '#loginForm', function (e) {
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
                $('#submit_login').prop('disabled', true).val('Chargement... ');
            },
            success: function (json) {
                if (json.statuts == 0) {
                    toastr.success(json.mes, "succès");
                    window.location.assign(json.direct);
                } else {
                    toastr.error(json.mes, "Echec");
                    $("#password").val("");
                }
            },
            complete: function () {
                $('#submit_login').prop('disabled', false).val('connexion');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
    $(document).on('submit', '#resetForm', function (e) {
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
                $('#submit_password').prop('disabled', true).val('Chargement... ');
            },
            success: function (json) {
                if (json.statuts == 0) {
                    toastr.success(json.mes, "succès");
                } else {
                    toastr.error(json.mes, "Echec");
                    $("#resetForm input").val("");
                }
            },
            complete: function () {
                $('#submit_password').prop('disabled', false).val('commandez');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });

});