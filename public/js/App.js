// Bootstrap tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
// Fin Bootrap tooltip

$( "#poteau_incendie" ).hide();
$( "#reserve_eau" ).hide();
$( "#reserve_naturelle_artificielle").hide();
$( "#separateur_hydrocarbure").hide();
$( "#vanne").hide();

//---------------------------------------------------------------------

$( "#btn-compteur_eau" ).click(function() {
    // Comportement de l'entête
    $( "#btn-compteur_eau" ).addClass( "active" );
    $("#btn-poteau_incendie").removeClass("active");
    $("#btn-reserve_eau").removeClass("active");
    $("#btn-reserve_naturelle_artificielle").removeClass("active");
    $("#btn-separateur_hydrocarbure").removeClass("active");
    $("#btn-vanne").removeClass("active");
    // Comportement du tableau
    $( "#compteur_eau" ).show();
    $( "#poteau_incendie" ).hide();
    $( "#reserve_eau" ).hide();
    $( "#reserve_naturelle_artificielle").hide();
    $( "#separateur_hydrocarbure").hide();
    $( "#vanne").hide();
});

$( "#btn-reserve_eau" ).click(function() {
     // Comportement de l'entête
     $( "#btn-compteur_eau" ).removeClass( "active" );
     $("#btn-poteau_incendie").removeClass("active");
     $("#btn-reserve_eau").addClass("active");
     $("#btn-reserve_naturelle_artificielle").removeClass("active");
     $("#btn-separateur_hydrocarbure").removeClass("active");
     $("#btn-vanne").removeClass("active");
     // Comportement du tableau
    $( "#compteur_eau" ).hide();
    $( "#poteau_incendie" ).hide();
    $( "#reserve_eau" ).show();
    $( "#reserve_naturelle_artificielle").hide();
    $( "#separateur_hydrocarbure").hide();
    $( "#vanne").hide();
});

$( "#btn-poteau_incendie" ).click(function() {
    // Comportement de l'entête
    $( "#btn-compteur_eau" ).removeClass( "active" );
    $("#btn-poteau_incendie").addClass("active");
    $("#btn-reserve_eau").removeClass("active");
    $("#btn-reserve_naturelle_artificielle").removeClass("active");
    $("#btn-separateur_hydrocarbure").removeClass("active");
    $("#btn-vanne").removeClass("active");
    // Comportement du tableau
    $( "#compteur_eau" ).hide();
    $( "#poteau_incendie" ).show();
    $( "#reserve_eau" ).hide();
    $( "#reserve_naturelle_artificielle").hide();
    $( "#separateur_hydrocarbure").hide();
    $( "#vanne").hide();
});

$( "#btn-reserve_naturelle_artificielle" ).click(function() {
    // Comportement de l'entête
    $( "#btn-compteur_eau" ).removeClass( "active" );
    $("#btn-poteau_incendie").removeClass("active");
    $("#btn-reserve_eau").removeClass("active");
    $("#btn-reserve_naturelle_artificielle").addClass("active");
    $("#btn-separateur_hydrocarbure").removeClass("active");
    $("#btn-vanne").removeClass("active");
    // Comportement du tableau
    $( "#compteur_eau" ).hide();
    $( "#poteau_incendie" ).hide();
    $( "#reserve_eau" ).hide();
    $( "#reserve_naturelle_artificielle").show();
    $( "#separateur_hydrocarbure").hide();
    $( "#vanne").hide();
});

$( "#btn-separateur_hydrocarbure" ).click(function() {
    // Comportement de l'entête
    $( "#btn-compteur_eau" ).removeClass( "active" );
    $("#btn-poteau_incendie").removeClass("active");
    $("#btn-reserve_eau").removeClass("active");
    $("#btn-reserve_naturelle_artificielle").removeClass("active");
    $("#btn-separateur_hydrocarbure").addClass("active");
    $("#btn-vanne").removeClass("active");
    // Comportement du tableau
    $( "#compteur_eau" ).hide();
    $( "#poteau_incendie" ).hide();
    $( "#reserve_eau" ).hide();
    $( "#reserve_naturelle_artificielle").hide();
    $( "#separateur_hydrocarbure").show();
    $( "#vanne").hide();
});

$( "#btn-vanne" ).click(function() {
    // Comportement de l'entête
    $( "#btn-compteur_eau" ).removeClass( "active" );
    $("#btn-poteau_incendie").removeClass("active");
    $("#btn-reserve_eau").removeClass("active");
    $("#btn-reserve_naturelle_artificielle").removeClass("active");
    $("#btn-separateur_hydrocarbure").removeClass("active");
    $("#btn-vanne").addClass("active");
    // Comportement du tableau
    $( "#compteur_eau" ).hide();
    $( "#poteau_incendie" ).hide();
    $( "#reserve_eau" ).hide();
    $( "#reserve_naturelle_artificielle").hide();
    $( "#separateur_hydrocarbure").hide();
    $( "#vanne").show();
});

// toggle icpe button
let rotateIcon = function(Id_Code_Icpe, Code_Icpe, Unite) {
    $( "#toggle_Icpe_"+Id_Code_Icpe).toggleClass('fa-rotate-90')
}

// Comportement des checkbox dans materiel ICPE
$(".check-locataire").click(function() {
    if($(".check-locataire:checked").length == $(".check-locataire").length) {
        $("#AllLocataire").prop("checked", false)
    }
})

$("#AllLocataire").click(function() {
    if($("#AllLocataire").prop("checked") == true) {
        $(".check-locataire").prop("checked", false)
    }
})
// Fin comportement des checkbox dans materiel ICPE

// Comportement du checkbox maison mère
if($("#flexCheckMm").prop("checked") == false) {
    $("#selectExisteMm").prop("disabled", true)

    $("#formNouveauMm").each(function() {
        $(this).find(':text').prop("disabled", true)
    })
} 

$("#flexCheckMm").click(function() {
    if ($("#flexCheckMm").prop("checked") == true) {
        if($("#radioExisteMm").prop("checked") == true) {
            $("#selectExisteMm").prop("disabled", false)
        }

        if ($("#radioNouveauMm").prop("checked") == true) {
            $("#formNouveauMm").each(function() {
                $(this).find(':text').prop("disabled", false)
            })
        }
    } else {
        $("#selectExisteMm").prop("disabled", true)

        $("#formNouveauMm").each(function() {
            $(this).find(':text').prop("disabled", true)
        })
    }
})

// Comportement des radios bouttons dans le formulaire d'ajout des batiment
$("#radioExisteMm").click(function() {
    if ($("#flexCheckMm").prop("checked") == true) {
        // Désactiver le véroue de selectExiste
        if($("#selectExisteMm").prop("disabled") == true) {
            $("#selectExisteMm").prop("disabled", false)
        }

        // Remove class collapse de selectExiste
        $("#formExistMm").removeClass("collapse")
    
        // Active le vérou des textbox nouveau maison mère
        $("#formNouveauMm").each(function() {
            $(this).find(':text').prop("disabled", true)
        })

        // Add class collapse de form nouveau maison mère
        $("#formNouveauMm").addClass("collapse")
    }
})

$("#radioNouveauMm").click(function() {
    if ($("#flexCheckMm").prop("checked") == true) {     
        // Activer le véroue de selectExiste
        if($("#selectExisteMm").prop("disabled") == false) {
            $("#selectExisteMm").prop("disabled", true);
        }

        // Add class collapse de form nouveau maison mère
        $("#formExistMm").addClass("collapse");
    
        // Désactivé le vérou des textbox nouveau maison mère
        $("#formNouveauMm").each(function() {
            $(this).find(':text').prop("disabled", false);
        })

        // Add class collapse de form nouveau maison mère
        $("#formNouveauMm").removeClass("collapse");
    }
})

// Comportement des radios buttons dans le formulaire d'ajout d'article
$("#radioExisteClient").click(function() {
    if($("#radioExisteClient").prop("checked") == true) {
        // Désactivé le véroue de selectExiste
        if($("#selectExistClient").prop("disabled") == true) {
            $("#selectExistClient").prop("disabled", false);
        }

        // Remove class collapse de form nouveau maison mère
        $("#formExistClient").removeClass("collapse");
    
        // Active le vérou des textbox nouveau maison mère
        $("#formNvClient").each(function() {
            $(this).find(':text').prop("disabled", true)
        })

        // Add class collapse de form nouveau maison mère
        $("#formNvClient").addClass("collapse");
    }
})

// Comportement des radios buttons dans le formulaire d'ajout d'article
$("#radioNvClient").click(function() {
    if($("#radioNvClient").prop("checked") == true) {
        // Désactivé le véroue de selectExiste
        if($("#selectExistClient").prop("disabled") == false) {
            $("#selectExistClient").prop("disabled", true);
        }

         // add class collapse de form nouveau maison mère
         $("#formExistClient").addClass("collapse");
    
        // Active le vérou des textbox nouveau maison mère
        $("#formNvClient").each(function() {
            $(this).find(':text').prop("disabled", false)
        })

        // Remove class collapse de form nouveau maison mère
        $("#formNvClient").removeClass("collapse");
    }
})

// Comportement des radios buttons dans le formulaire d'ajout d'article
//  Les Zone de stockage
$("#radioZoneStockage").click(function() {
    // Désactivé le véroue de selectExiste Zone stockage
    if($("#selectZoneStockage").prop("disabled") == true) {
        $("#selectZoneStockage").prop("disabled", false);
    }

    // Remove class collapse de form nouveau maison mère
    $("#formZoneStockage").removeClass("collapse");

    // Activé le véroue de selectExiste Emplacement
    if($("#selectEmplacement").prop("disabled") == false) {
        $("#selectEmplacement").prop("disabled", true);
    }

    // add class collapse de form nouveau maison mère
    $("#formEmplacementEnregistre").addClass("collapse");

    // Active le vérou des textbox nouveau emplacement
    $("#formNvEmplacement").each(function() {
        $(this).find(':text').prop("disabled", true)
    })

    // add class collapse de form nouveau maison mère
    $("#formNvEmplacement").addClass("collapse");
})

//  Les Emplacement de stockage existant
$("#radioExisteEmplacement").click(function() {
    // Activé le véroue de selectExiste Zone stockage
    if($("#selectZoneStockage").prop("disabled") == false) {
        $("#selectZoneStockage").prop("disabled", true);
    }

    // Add class collapse de selectExiste Zone stockage
    $("#formZoneStockage").addClass("collapse");

    // Désactivé le véroue de selectExiste Emplacement
    if($("#selectEmplacement").prop("disabled") == true) {
        $("#selectEmplacement").prop("disabled", false);
    }

    // Remove class collapse de form nouveau maison mère
    $("#formEmplacementEnregistre").removeClass("collapse");

    // Active le vérou des textbox nouveau emplacement
    $("#formNvEmplacement").each(function() {
        $(this).find(':text').prop("disabled", true)
    })

    // Add class collapse de form nouveau maison mère
    $("#formNvEmplacement").addClass("collapse");

});

//  Les Nouveau emplacement de stockage
$("#radioNvEmplacement").click(function() {
    // Activé le véroue de selectExiste Zone stockage
    if($("#selectZoneStockage").prop("disabled") == false) {
        $("#selectZoneStockage").prop("disabled", true);
    }

    // Add class collapse de selectExiste Zone stockage
    $("#formZoneStockage").addClass("collapse");

    // Activé le véroue de selectExiste emplacement enregistrer
    if($("#selectEmplacement").prop("disabled") == false) {
        $("#selectEmplacement").prop("disabled", true);
    }

    // Add class collapse de selectExiste emplacement enregistré
    $("#formEmplacementEnregistre").addClass("collapse");

    // Desactivé le vérou des textbox nouveau emplacement
    $("#formNvEmplacement").each(function() {
        $(this).find(':text').prop("disabled", false)
    })

    // Remove class collapse de form nouveau nouveau emplacement
    $("#formNvEmplacement").removeClass("collapse");
})