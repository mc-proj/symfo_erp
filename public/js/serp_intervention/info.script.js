$(document).ready(function() {    

    $("body").on("click", "#cree-intervention", function() {

        if($("#titre-modale-intervention").text() == "Créer une nouvelle intervention") {

            $("#modale-formulaire-intervention").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_intervention,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-intervention").text("Créer une nouvelle intervention");
                    $("#corps-modale-intervention").html(response);
                    $("#modale-formulaire-intervention").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-intervention", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_intervention,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-intervention").text("Modifier une intervention");
                $("#corps-modale-intervention").html(response);
                $("#modale-formulaire-intervention").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-intervention", function() {
        
        loader(true);
        let memo_id = $(this).data("id");

        $.ajax({
            type: "POST",
            url: route_efface_intervention,
            data: {
                id: memo_id
            },
            success: function() {

                loader(false);
                $("*[data-id='" + memo_id + "']").parent().parent().remove();

                //s'il n'y a plus d'intervention
                if($(".row-intervention").length == 0) {
                    //on insere le message qui informe de l'absence de données
                    let insert = "<tr class='row-intervention'>";
                    insert += "<td colspan='7'>Aucune intervention disponible</td>";
                    insert += "</tr>";
                    $("#body-info").prepend(insert);
                }

                toastr.success("intervention effacée avec succès");
            },
            error: function(/*err*/) {

                loader(false);
                toastr.error("Erreur: un problème est survenu lors de la suppression de l'intervention");
                //console.log(err);
            }
        })
    });

    function loader(show) {

        if(show) {
            $("#loader").show();
        } else {
            $("#loader").hide();
        }
    }
});