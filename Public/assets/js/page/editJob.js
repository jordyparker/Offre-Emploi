$(document).ready(function(){
    $('.description').ckeditor(function(){},
        {
            customConfig:'../../assets/plugins/ckeditor_config.js'
        });
    $(document).on('click','#editJob', function (e) {
        e.preventDefault();
        var titre = $(this).data('titre'),
            description = $(this).data('description'),
            categorie = $(this).data('categorie'),
            delais = $(this).data('delais'),
            lieu = $(this).data('lieu'),
            ville = $(this).data('ville'),
            salaire = $(this).data('salaire'),
            domaine = $(this).data('domaine'),
            id = $(this).data('ido');
        $('.title').val(titre);
        $('#description').val(description);
        $('.type').val(categorie);
        $('#delais').val(delais);
        $('#lieu').val(lieu);
        $('#ville').val(ville);
        $('#salaire').val(salaire);
        $('#domaine').val(domaine);
        $('#offre').val(id);
        $('#modalJob').modal('show');
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
    $(document).on('click','#deleteJob', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id');
        swal({
                title: "Etes vous sûr?",
                text: "Cet emploi va être supprimé",
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
                            type: 'POST',
                            url: url,
                            data: 'id='+id,
                            datatype: 'json',
                            beforeSend: function () {},
                            success: function (json) {
                                if (json.statuts == 0) {
                                    toastr.success(json.mes,'Succes!');
                                    window.location.reload();
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
    $('.date').datepicker();

});