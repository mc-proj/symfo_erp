$(document).ready(function() {    

    $("body").on("click", "#cree-matiere", function() {

        if($("#titre-modale-matiere").text() == "Créer une nouvelle matiere") {

            $("#modale-formulaire-matiere").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_matiere,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-matiere").text("Créer une nouvelle matiere");
                    $("#corps-modale-matiere").html(response);
                    $("#modale-formulaire-matiere").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-matiere", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_matiere,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-matiere").text("Modifier une matiere");
                $("#corps-modale-matiere").html(response);
                $("#modale-formulaire-matiere").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-matiere", function() {
        
        loader(true);
        let memo_id = $(this).data("id");

        $.ajax({
            type: "POST",
            url: route_efface_matiere,
            data: {
                id: memo_id
            },
            success: function() {

                loader(false);
                $("*[data-id='" + memo_id + "']").parent().parent().remove();

                //s'il n'y a plus de matiere
                if($(".row-matiere").length == 0) {
                    //on insere le message qui informe de l'absence de données
                    let insert = "<tr class='row-matiere'>";
                    insert += "<td colspan='7'>Aucune matière disponible</td>";
                    insert += "</tr>";
                    $("#body-info").prepend(insert);
                }

                toastr.success("matiere effacée avec succès");
            },
            error: function(/*err*/) {

                loader(false);
                toastr.error("Erreur: un problème est survenu lors de la suppression de la matiere");
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