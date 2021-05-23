$(document).ready(function() {
    
    $("#btn-cree-intervention").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-intervention]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_intervention,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    toastr.success("Nouvelle intervention enregistrée avec succes");
                    //retrait du bouton "creer une nouvelle intervention
                    $("#tr-valide").remove();

                    //s'il n'y a aucune intervention à la base
                    if($(".row-intervention td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-intervention").remove();
                    }

                    let date_debut = DateUsVersFr($("#serp_intervention_date_debut_date").val());
                    let date_fin = DateUsVersFr($("#serp_intervention_date_fin_date").val());
                    let observation = $("#serp_intervention_observation").val();

                    if(typeof(observation) == "undefined") {
                        observation = "";
                    }

                    var row = $("<tr class='row-intervention'>");
                    row.append($("<td>" + $("#serp_intervention_id_type_intervention").find("option:selected").text() + "</td>"))
                        .append($("<td>" + $("#serp_intervention_id_machine").find("option:selected").text() + "</td>"))
                        .append($("<td>" + $("#serp_intervention_id_intervenant").find("option:selected").text() + "</td>"))
                        .append($("<td>" + date_debut + ' ' + $("#serp_intervention_date_debut_time").val()  + "</td>"))
                        .append($("<td>" + date_fin + ' ' + $("#serp_intervention_date_fin_time").val()  + "</td>"))
                        .append($("<td>" + observation + "</td>"))
                        .append($("<td><button class='btn btn-primary edite-intervention' data-id='" + id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-intervention' data-id='" + id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);
                    //retour du bouton "creer une nouvelle intervention"
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='8'><button class='btn btn-primary' id='cree-intervention'>Créer un nouvel intervenant</button></td></tr>"));

                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-intervention").modal("hide");
                    $("#serp_intervention_id_type_intervention").val($("#serp_intervention_id_type_intervention option:first").val());
                    $("#serp_intervention_id_machine").val($("#serp_intervention_id_machine option:first").val());
                    $("#serp_intervention_id_intervenant").val($("#serp_intervention_id_intervenant option:first").val());
                    $("#serp_intervention_date_debut_date").val("");
                    $("#serp_intervention_date_debut_time").val("");
                    $("#serp_intervention_date_fin_date").val("");
                    $("#serp_intervention_date_fin_time").val("");
                    $("#serp_intervention_observation").val("");
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

    //retire les message d'erreur d'un champ (si present)
    $(".form-control").on("click", function() {
        let id_base = $(this).attr("id");

        if(typeof(id_base) != "undefined") {

            id_base = id_base.split("serp_intervention_");
            let verif = id_base[1].split("_");

            if(verif[0] == "date") {
                $("#erreur_intervention_" + verif[0] + "_" + verif[1]).remove();
            } else {
                $("#erreur_intervention_" + id_base[1]).remove();
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