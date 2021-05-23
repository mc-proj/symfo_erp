$(document).ready(function() {

    $("#btn-edition-intervention").on("click", function() {

        loader(true);
        let form = $("[name=form-edition-intervention]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_edite_intervention,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    let date_debut = DateUsVersFr($("#serp_intervention_date_debut_date").val());
                    let date_fin = DateUsVersFr($("#serp_intervention_date_fin_date").val());
                    let observation = $("#serp_intervention_observation").val();

                    if(typeof(observation) == "undefined") {
                        observation = "";
                    }

                    $('*[data-id="' + id + '"]').parent().parent().children().eq(0).text($("#serp_intervention_id_type_intervention").find("option:selected").text());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(1).text($("#serp_intervention_id_machine").find("option:selected").text());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(2).text($("#serp_intervention_id_intervenant").find("option:selected").text());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(3).text(date_debut + ' ' + $("#serp_intervention_date_debut_time").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(4).text(date_fin + ' ' + $("#serp_intervention_date_fin_time").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(5).text(observation);
                    $("#modale-formulaire-intervention").modal("hide");
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_intervention_" + nom).prev().append('<div class="texte-rouge" id="erreur_intervention_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');

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

            id_base = id_base.split("serp_intervention_");
            $("#erreur_intervention_" + id_base[1]).remove();
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