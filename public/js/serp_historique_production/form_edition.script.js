$(document).ready(function() {

    $("#btn-edition-historique").on("click", function() {

        loader(true);
        let form = $("[name=form-edition-historique]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_edite_historique,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let date_debut = DateUsVersFr($("#serp_historique_production_date_debut_date").val());
                    let date_fin = DateUsVersFr($("#serp_historique_production_date_fin_date").val());
                    let id = erreurs;
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(0).text($("#serp_historique_production_id_of").find("option:selected").text());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(1).text(date_debut + ' ' + $("#serp_historique_production_date_debut_time").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(2).text(date_fin + ' ' + $("#serp_historique_production_date_fin_time").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(3).text($("#serp_historique_production_id_intervenant").find("option:selected").text());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(4).text($("#serp_historique_production_quantite_debut").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(5).text($("#serp_historique_production_quantite_fin").val());
                    $("#modale-formulaire-historique").modal("hide");
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_historique_production_" + nom).prev().append('<div class="texte-rouge" id="erreur_historique_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');
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

            id_base = id_base.split("serp_historique_production_");
            let verif = id_base[1].split("_");

            if(verif[0] == "date") {
                $("#erreur_historique_" + verif[0] + "_" + verif[1]).remove();
            } else {
                $("#erreur_historique_" + id_base[1]).remove();
            }
        }
    })

    function DateUsVersFr(date_us) {

        let date_fr = date_us.split('-');
        return(date_fr[2] + "/" + date_fr[1] + "/" + date_fr[0]);
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