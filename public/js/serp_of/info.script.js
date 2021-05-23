$(document).ready(function() {    

    $("body").on("click", "#cree-of", function() {

        if($("#titre-modale-of").text() == "Créer un nouvel ordre de fabrication") {

            $("#modale-formulaire-of").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_of,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-of").text("Créer un nouvel ordre de fabrication");
                    $("#corps-modale-of").html(response);
                    $("#modale-formulaire-of").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-of", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_of,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-of").text("Modifier un ordre de fabrication");
                $("#corps-modale-of").html(response);
                $("#modale-formulaire-of").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-of", function() {

        let confirmation = confirm("Supprimer cet Ordre de Fabrication entrainera la suppression des historiques de production et des controles qualites liés. Voulez vous continuer ?");
        if(confirmation) {
            loader(true);
            let memo_id = $(this).data("id");

            $.ajax({
                type: "POST",
                url: route_efface_of,
                data: {
                    id: memo_id
                },
                success: function() {

                    loader(false);
                    $("*[data-id='" + memo_id + "']").parent().parent().remove();

                    //s'il n'y a plus d'of'
                    if($(".row-of").length == 0) {
                        //on insere le message qui informe de l'absence de données
                        let insert = "<tr class='row-of'>";
                        insert += "<td colspan='7'>Aucun of disponible</td>";
                        insert += "</tr>";
                        $("#body-info").prepend(insert);
                    }

                    toastr.success("ordre de fabrication effacé avec succès");
                },
                error: function(/*err*/) {

                    loader(false);
                    toastr.error("Erreur: un problème est survenu lors de la suppression de l'ordre de fabrication");
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