$(document).ready(function(){
    $(document).on('click','#deleteEntreprise', function (e) {
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
                            type: 'POST',
                            url: url,
                            data: 'id='+id,
                            datatype: 'json',
                            beforeSend: function () {},
                            success: function (json) {
                                if (json.statuts == 0) {
                                    toastr.success(json.mes,'Succes!');
                                    window.location.assign(json.redirects);
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