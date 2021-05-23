$(document).ready(function() {

    $(".list-group-item").on("click", function() {

        let url_route = determineRoute($(this).attr("id"));
        $(this).addClass("categorie-selectionnee").siblings().removeClass("categorie-selectionnee");
        loader(true);

        $.ajax({
            type: "POST",
            //url: route_info_client,
            url: url_route,
            success: function(response) {
                $("#bloc-infos").html(response);
                $("#bloc-infos").css("align-items", "flex-start");
                loader(false);
            },
            error: function(err) {

                loader(false);
                //console.log(err);
            }
        })
    });

    function determineRoute(id) {

        let route;

        switch(id) {

            case "client":
                route = route_info_client;
                break;

            case "controle qualite":
                route = route_info_qualite;
                break;

            case "historique de production":
                route = route_info_historique;
                break;

            case "intervenant":
                route = route_info_intervenant;
                break;

            case "intervention":
                route = route_info_intervention;
                break;

            case "machine":
                route = route_info_machine;
                break;

            case "matiere":
                route = route_info_matiere;
                break;

            case "ordre de fabrication":
                route = route_info_of;
                break;

            case "produit":
                route = route_info_produit;
                break;
        };

        return route;
    }

    function loader(show) {

        if(show) {
            $("#loader").show();
        } else {
            $("#loader").hide();
        }
    }
})