$(document).ready(function(){
    $('.description').ckeditor(function(){},
        {
            customConfig:'../../assets/plugins/ckeditor_config.js'
        });
    $('.date').datepicker();
    $(document).on('click','#editEtab', function (e) {
        e.preventDefault();
        var nom = $(this).data('etablissement'),
            diplome = $(this).data('diplome'),
            anne = $(this).data('annee'),
            url = $(this).data('url'),
            id = $(this).data('id');
        $('#etablissement').val(nom);
        $('#diplome').val(diplome);
        $('#annee').val(anne);
        $('#idForm').val(id);
        $('#action').val('edit');
        $('#modalEtab').modal('show');
    });
    $(document).on('click','#editExp', function (e) {
        e.preventDefault();
        var nom = $(this).data('nomentreprise'),
            dated = $(this).data('dated'),
            datef = $(this).data('datef'),
            description = $(this).data('description'),
            url = $(this).data('url'),
            id = $(this).data('id');
        $('#nomentreprise').val(nom);
        $('#dated').val(dated);
        $('#datef').val(datef);
        $('#description').val(description);
        $('#idExp').val(id);
        $('#action').val('edit');
        $('#modalExp').modal('show');
    });
    $(document).on('click','#editCmp', function (e) {
        e.preventDefault();
        var nom = $(this).data('competence'),
            pourcentage = $(this).data('pourcentage'),
            url = $(this).data('url'),
            id = $(this).data('id');
        $('#nomcompetence').val(nom);
        $('#pourcentage').val(pourcentage);
        $('#idCmp').val(id);
        $('#action').val('edit');
        $('#modalCmp').modal('show');
    });
    $(document).on('click','#editLang', function (e) {
        e.preventDefault();
        var langue = $(this).data('langue'),
            id = $(this).data('id');
        $('#descriptionl').val(langue);
        $('#idLang').val(id);
        $('#action').val('edit');
        $('#modalLang').modal('show');
    });
    $(document).on('submit', '#addEtab', function (e) {
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
                $('#btnetab').text('Chargement...').prop('disabled', true);
            },
            success: function (json) {
                if(json.statuts == 0) {
                    toastr.success(json.mes,'Success!')
                    window.location.reload();
                }else {
                    toastr.error(json.mes,'Oups!');
                }
            },
            complete: function () {
                $('#btnetab').text('Soumettre').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $(document).on('submit', '#addExp', function (e) {
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
                $('#btnexp').text('Chargement ...').prop('disabled', true);
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
                $('#btnexp').text('Soumettre').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $(document).on('submit', '#addCmp', function (e) {
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
                $('#btncmp').text('Soumettre').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $(document).on('submit', '#addLang', function (e) {
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
                $('#btnlang').text('Chargement ...').prop('disabled', true);
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
                $('#btnlang').text('Soumettre').prop('disabled',false);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
});