$(document).ready(function() {

    $("#btn-edition-of").on("click", function() {

        loader(true);
        let form = $("[name=form-edition-of]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_edite_of,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    let date = dateUsaVersFr($("#serp_of_date_commande").val());
                    //a adapter
                    //$("#serp_of_date_commande")

                    $('*[data-id="' + id + '"]').parent().parent().children().eq(0).text($("#serp_of_id_client").find("option:selected").text());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(1).text($("#serp_of_quantite_commandee").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(2).text(date);
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(3).text($("#serp_of_machine_id").find("option:selected").text());
                    $("#modale-formulaire-of").modal("hide");
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_of_" + nom).prev().append('<div class="texte-rouge" id="erreur_of_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');

                    }
                }
            },
            error: function(/*err*/) {

                loader(false);
                //console.log(err);
            }
        })
    });

    $(".form-control").on("click", function() {

        let id_base = $(this).attr("id");

        if(typeof(id_base) != "undefined") {

            id_base = id_base.split("serp_of_");
            $("#erreur_of_" + id_base[1]).remove();
        }
    })

    function dateUsaVersFr(date_usa) {

        date_usa += "";
        date_usa = date_usa.split('-');
        date_usa = date_usa[2] + "/" + date_usa[1] + "/" + date_usa[0];
        return date_usa;
    }

    $.fn.serializeObject = function() {

        let o = {};
        let a = this.serializeArray();
        $.each(a, function() {

            if(o[this.name]) {

                if(!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value||'');
            } else {
                o[this.name] = this.value||'';
            }
        });
        return o;
    }

    function loader(show) {

        if(show) {
            $("#loader").show();
        } else {
            $("#loader").hide();
        }
    }
});