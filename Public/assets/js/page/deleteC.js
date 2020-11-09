$(document).ready(function(){
    $(document).on('click','#deleteC', function (e) {
        e.preventDefault();
        var url = $(this).data('url'),
            id = $(this).data('id'),
            ido = $(this).data('ido');
        swal({
                title: "Etes vous sûr?",
                text: "Votre candidature va être supprimé",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#662400",
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Annuler",
                closeOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    if(url!=''&&id!=''&&ido!=''){
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: 'id='+id+'&ido='+ido,
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
});