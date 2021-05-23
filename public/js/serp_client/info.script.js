$(document).ready(function() {    

    $("body").on("click", "#cree-client", function() {

        if($("#titre-modale-client").text() == "Créer un nouveau client") {

            $("#modale-formulaire-client").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_client,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-client").text("Créer un nouveau client");
                    $("#corps-modale-client").html(response);
                    $("#modale-formulaire-client").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-client", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_client,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-client").text("Modifier un client");
                $("#corps-modale-client").html(response);
                $("#modale-formulaire-client").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-client", function() {

        let confirmation = confirm("Supprimer ce client la suppression des Ordres de Fabrication liés. Voulez vous continuer ?");
        if(confirmation) {
            loader(true);
            let memo_id = $(this).data("id");

            $.ajax({
                type: "POST",
                url: route_efface_client,
                data: {
                    id: memo_id
                },
                success: function() {

                    loader(false);
                    $("*[data-id='" + memo_id + "']").parent().parent().remove();
                    //s'il n'y a plus de clients
                    if($(".row-client").length == 0) {
                        //on insere le message qui informe de l'absence de données
                        let insert = "<tr class='row-client'>";
                        insert += "<td colspan='7'>Aucun client disponible</td>";
                        insert += "</tr>";
                        $("#body-info").prepend(insert);
                    }

                    toastr.success("client effacé avec succès");
                },
                error: function(err) {

                    loader(false);
                    toastr.error("Erreur: un problème est survenu lors de la suppression du client");
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