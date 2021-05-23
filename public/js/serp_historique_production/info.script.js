$(document).ready(function() {    

    $("body").on("click", "#cree-historique", function() {

        if($("#titre-modale-historique").text() == "Créer un nouvel historique") {

            $("#modale-formulaire-historique").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_historique,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-historique").text("Créer un nouvel historique");
                    $("#corps-modale-historique").html(response);
                    $("#modale-formulaire-historique").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-historique", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_historique,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-historique").text("Modifier un historique");
                $("#corps-modale-historique").html(response);
                $("#modale-formulaire-historique").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-historique", function() {
        
        loader(true);
        let memo_id = $(this).data("id");

        $.ajax({
            type: "POST",
            url: route_efface_historique,
            data: {
                id: memo_id
            },
            success: function() {

                loader(false);
                $("*[data-id='" + memo_id + "']").parent().parent().remove();

                //s'il n'y a plus d'historique
                if($(".row-historique").length == 0) {
                    //on insere le message qui informe de l'absence de données
                    let insert = "<tr class='row-historique'>";
                    insert += "<td colspan='7'>Aucun historique disponible</td>";
                    insert += "</tr>";
                    $("#body-info").prepend(insert);
                }

                toastr.success("historique effacé avec succès");
            },
            error: function(/*err*/) {

                loader(false);
                toastr.error("Erreur: un problème est survenu lors de la suppression de l'historique");
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