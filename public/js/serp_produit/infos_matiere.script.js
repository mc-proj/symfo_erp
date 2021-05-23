$(document).ready(function() { 

    $("body").on("click", "#ajoute-matiere-produit", function() {

        if($("#titre-modale-matiere_liee").text() == "Lier une nouvelle matière") {

            $("#modale-formulaire-matiere_liee").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_nouvelle_matiere,
                data: {
                    id_produit: id_produit
                },
                success: function(response) {

                    loader(false);
                    $("#titre-modale-matiere_liee").text("Lier une nouvelle matière");
                    $("#corps-modale-matiere_liee").html(response);
                    $("#modale-formulaire-matiere_liee").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-matiere-produit", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_edite_matiere,
            data: {
                id: $(this).data("id"),
                id_produit: id_produit
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-matiere_liee").text("Modifier une matière liée");
                $("#corps-modale-matiere_liee").html(response);
                $("#modale-formulaire-matiere_liee").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-matiere-produit", function() {
        
        loader(true);
        let memo_id = $(this).data("id");

        $.ajax({
            type: "POST",
            url: route_supprime_matiere,
            data: {
                id: memo_id
            },
            success: function() {

                loader(false);
                $("*[data-id='" + memo_id + "']").parent().parent().remove();
                toastr.success("matière liée effacée avec succès");
            },
            error: function(/*err*/) {

                loader(false);
                toastr.error("Erreur: un problème est survenu lors de la suppression du produit");
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