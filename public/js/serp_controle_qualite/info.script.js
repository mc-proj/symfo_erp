$(document).ready(function() {    

    $("body").on("click", "#cree-qualite", function() {

        if($("#titre-modale-qualite").text() == "Créer un nouveau controle qualité") {

            $("#modale-formulaire-qualite").modal("show");
        } else {

            loader(true);

            $.ajax({
                type: "POST",
                url: route_get_qualite,
                success: function(response) {

                    loader(false);
                    $("#titre-modale-qualite").text("Créer un nouveau controle qualité");
                    $("#corps-modale-qualite").html(response);
                    $("#modale-formulaire-qualite").modal("show");
                },
                error: function(err) {

                    loader(false);
                    //console.log(err);
                }
            })
        }
    });

    $("#body-info").on("click", ".edite-qualite", function() {

        loader(true);

        $.ajax({
            type: "POST",
            url: route_get_edite_qualite,
            data: {
                id: $(this).data("id")
            },
            success: function(response) {

                loader(false);
                $("#titre-modale-qualite").text("Modifier un controle qualité");
                $("#corps-modale-qualite").html(response);
                $("#modale-formulaire-qualite").modal("show");
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $("#body-info").on("click", ".efface-qualite", function() {
        
        loader(true);
        let memo_id = $(this).data("id");

        $.ajax({
            type: "POST",
            url: route_efface_qualite,
            data: {
                id: memo_id
            },
            success: function() {

                loader(false);
                $("*[data-id='" + memo_id + "']").parent().parent().remove();
                
                //s'il n'y a plus de controles qualite
                if($(".row-qualite").length == 0) {
                    //on insere le message qui informe de l'absence de données
                    let insert = "<tr class='row-qualite'>";
                    insert += "<td colspan='7'>Aucun controle qualité disponible</td>";
                    insert += "</tr>";
                    $("#body-info").prepend(insert);
                }

                toastr.success("controle qualité effacé avec succès");
            },
            error: function(/*err*/) {

                loader(false);
                toastr.error("Erreur: un problème est survenu lors de la suppression du controle qualité");
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