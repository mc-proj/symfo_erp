$(document).ready(function() {    

    $("body").on("click", "#cree-machine", function() {

        if($("#titre-modale-machine").text() == "Créer une nouvelle machine") {

            $("#modale-formulaire-machine").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_machine,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-machine").text("Créer une nouvelle machine");
                    $("#corps-modale-machine").html(response);
                    $("#modale-formulaire-machine").modal("show");
                },
                error: function(/*err*/) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-machine", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_machine,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-machine").text("Modifier une machine");
                $("#corps-modale-machine").html(response);
                $("#modale-formulaire-machine").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-machine", function() {

        let confirmation = confirm("Supprimer cette machine entrainera la suppression des interventions et des Ordres de Fabrication liés. Voulez vous continuer ?");
        if(confirmation) {
            loader(true);
            let memo_id = $(this).data("id");

            $.ajax({
                type: "POST",
                url: route_efface_machine,
                data: {
                    id: memo_id
                },
                success: function() {

                    loader(false);
                    $("*[data-id='" + memo_id + "']").parent().parent().remove();

                    //s'il n'y a plus de machine
                    if($(".row-machine").length == 0) {
                        //on insere le message qui informe de l'absence de données
                        let insert = "<tr class='row-machine'>";
                        insert += "<td colspan='7'>Aucune machine disponible</td>";
                        insert += "</tr>";
                        $("#body-info").prepend(insert);
                    }

                    toastr.success("machine effacée avec succès");
                },
                error: function(/*err*/) {

                    loader(false);
                    toastr.error("Erreur: un problème est survenu lors de la suppression de la machine");
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