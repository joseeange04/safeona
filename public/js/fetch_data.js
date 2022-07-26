$(document).on('click', '#get_reglement_icpe', function () {
    var code_icpe = $(this).val();
    $.ajax({
        type: "GET",
        url: "../pages/action_matiere_icpe.php",
        data: {Code_Icpe: code_icpe},
        dataType:"json",
        success: function (response) {
            $('#modal_reglement_icpe').modal('show');
            $('#cel-icpe').html(response[0].Code_icpe);
            $('#cel-designation').html(response[0].Designation_rubrique);
        },
        error: function() {
            console.log('Erreur ajax de reglement ICPE');
        }
    });
});

$(document).on('click', '#get_article_details', function () {
    var num_article = $(this).val();
    //$('#modal_article_details').modal('show');
    $.ajax({
        type: "GET",
        url: "../pages/action_matiere_icpe.php",
        data: {Article_Details: num_article},
        dataType: "json",
        beforeSend: function () {
            $('#modal-loading').modal('show');
        },
        complete: function () {
            $('#modal-loading').modal('hide');
        },
        success: function (response) {
            console.log(response);
            $('#modal_article_details').modal('show');
            $('#cel-details-article').html(response.Article);
            $('#cel-details-pmd').html(response.Pmd);
            $('#cel-details-qte').html(response.Qte);
            $('#cel-details-unite').html(response.Unite);
            $('#cel-details-emplacement').html(response.Emplacement);
            $('#cel-details-allee').html(response.Allee);
            $('#cel-details-rack').html(response.Rack);

            // Liste des mention de danger
            $('#cel-details-hxxx').html('') // Nétoyer la cellule Hxxx
            if (response.Hxxx.length > 0) {
                $('#cel-details-hxxx').append('<button id="cel-details-btn-hxxx" class="btn border-0 col-12 text-center" type="button" value="'+ response.Num_article +'"></button>');
                for(let i = 0; i < response.Hxxx.length; i++) {
                    $('#cel-details-btn-hxxx').append(response.Hxxx[i].Hxxx + "   ");
                }
            }
            // Liste des pictogrammes
            $('#cel-details-paths').html(''); // Nétoyer la cellule pictogramme
            if (response.Paths.length > 0) {
                for(let i = 0; i < response.Paths.length; i++) {
                    $('#cel-details-paths').append('<img class="img-fluid me-1" style="width: 150px;" src=' + response.Paths[i].Path +' />');
                }
            }
            // Liste des préventions
            $('#cel-details-preventions').html('')  // Nétoyer la cellule Pxxx
            if (response.Preventions.length > 0) {
                for(let i = 0; i < response.Preventions.length; i++) {
                    $('#cel-details-preventions').append(response.Preventions[i].Pxxx + "  ");
                }
            }
        },
        error: function () {
            console.log('Erreur ajax article details');
        }
    });
});

$(document).on('click', '#cel-details-btn-hxxx', function () {
    var num_article = $(this).val();
    $.ajax({
        type: "GET",
        url: "../pages/action_matiere_icpe.php",
        data: {Hxxx_Description: num_article},
        dataType: "json",
        beforeSend: function () {
            $('#modal-loading').modal('show');
        },
        complete: function () {
            $('#modal-loading').modal('hide');
        },
        success: function (response) {
            $('#description_danger').modal('show');
            for(let i = 0; i < response.length; i++) {
                $('#cel-danger-hxxx').html(response[i].Hxxx);
                $('#cel-danger-descriptif').html(response[i].Descriptif);
            }
        },
        error: function () {
            console.log('Erreur ajax hxxx déscription.');
        }
    });
});

$(document).on('click', '#get_prevention', function () {

});