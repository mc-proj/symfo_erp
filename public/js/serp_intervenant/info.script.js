$(document).ready(function() {    

    $("body").on("click", "#cree-intervenant", function() {

        if($("#titre-modale-intervenant").text() == "Créer un nouvel intervenant") {

            $("#modale-formulaire-intervenant").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_intervenant,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-intervenant").text("Créer un nouvel intervenant");
                    $("#corps-modale-intervenant").html(response);
                    $("#modale-formulaire-intervenant").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-intervenant", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_intervenant,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-intervenant").text("Modifier un intervenant");
                $("#corps-modale-intervenant").html(response);
                $("#modale-formulaire-intervenant").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-intervenant", function() {

        let confirmation = confirm("Supprimer cet intervenant entrainera la suppression des interventions liées. Voulez vous continuer ?");
        if(confirmation) {
            loader(true);
            let memo_id = $(this).data("id");

            $.ajax({
                type: "POST",
                url: route_efface_intervenant,
                data: {
                    id: memo_id
                },
                success: function() {

                    loader(false);
                    $("*[data-id='" + memo_id + "']").parent().parent().remove();

                    //s'il n'y a plus d'intervenant'
                    if($(".row-intervenant").length == 0) {
                        //on insere le message qui informe de l'absence de données
                        let insert = "<tr class='row-intervenant'>";
                        insert += "<td colspan='7'>Aucun intervenant disponible</td>";
                        insert += "</tr>";
                        $("#body-info").prepend(insert);
                    }

                    toastr.success("intervenant effacé avec succès");
                },
                error: function(/*err*/) {

                    loader(false);
                    toastr.error("Erreur: un problème est survenu lors de la suppression de l'intervenant");
                    //console.log(err);
                }
            })
        }
    });

    function loader(show) {

        if(show) {
            $("#loader").show();
        } else {
            $("#loader").hide();
        }
    }
});