$(document).ready(function() {    

    $("body").on("click", "#cree-produit", function() {

        if($("#titre-modale-produit").text() == "Créer un nouveau produit") {

            $("#modale-formulaire-produit").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_produit,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-produit").text("Créer un nouveau produit");
                    $("#corps-modale-produit").html(response);
                    $("#modale-formulaire-produit").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-produit", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_produit,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-produit").text("Modifier un produit");
                $("#corps-modale-produit").html(response);
                $("#modale-formulaire-produit").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-produit", function() {
        
        loader(true);
        let memo_id = $(this).data("id");

        $.ajax({
            type: "POST",
            url: route_efface_produit,
            data: {
                id: memo_id
            },
            success: function() {

                loader(false);
                $("*[data-id='" + memo_id + "']").parent().parent().remove();

                //s'il n'y a plus de produit
                if($(".row-produit").length == 0) {
                    //on insere le message qui informe de l'absence de données
                    let insert = "<tr class='row-produit'>";
                    insert += "<td colspan='7'>Aucun produit disponible</td>";
                    insert += "</tr>";
                    $("#body-info").prepend(insert);
                }

                toastr.success("produit effacé avec succès");
            },
            error: function(/*err*/) {

                loader(false);
                toastr.error("Erreur: un problème est survenu lors de la suppression du produit");
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".bouton-matiere", function() {

        loader(true);
        let nom_produit = $(this).parent().prev().eq(0).text();
        $.ajax({
            type: "POST",
            url: route_info_matieres,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                //on enleve le contenu precedent
                $("#col-menu-lateral").empty();
                //on affiche le contenu recuperé
                $("#col-menu-lateral").append(response);
                //changement nom matiere dans menu
                $("#nom-produit-matieres").text(nom_produit);
                //apparition menu matieres
                $("#menu-lateral").css("display", "block");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#bouton-fermeture-lateral").on("click", function() {
        //fermeture menu matieres
        $("#menu-lateral").css("display", "none");
    });

    function loader(show) {

        if(show) {
            $("#loader").show();
        } else {
            $("#loader").hide();
        }
    }
});