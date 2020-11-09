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
    $(document).on('submit', '#formU', function (e) {
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
                $('#btnU').text('Modification ...').prop('disabled', true);
            },
            success: function (json) {
                if(json.statuts == 0) {
                    toastr.success(json.mes,'Success!');
                    window.location.assign('http://offreemploi.test/login');
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
    $(document).on('submit', '#updateForm', function (e) {
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
                $('#btnC').text('Modification...').prop('disabled', true);
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
                $('#btnC').text('Modifier mon compte').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $(document).on('click','.deleteUser', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "Votre compte va être supprimé",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#662400",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    if(url!=''&&id!=''){
                        $.ajax({
                            type: 'post',
                            url: url,
                            data: 'id='+id,
                            datatype: 'json',
                            beforeSend: function () {},
                            success: function (json) {
                                if (json.statuts == 0) {
                                    toastr.success(json.mes,'Succes!');
                                    window.location.assign("login");
                                } else {
                                    toastr.error(json.mes,'Oups!')
                                }
                            },
                            complete: function () {},
                            error: function (jqXHR, textStatus, errorThrown) {}
                        });
                    }else{
                        toastr.error("Une erreur est apparu rechargez la page",'Oups');
                    }
                }
            });

    });
});