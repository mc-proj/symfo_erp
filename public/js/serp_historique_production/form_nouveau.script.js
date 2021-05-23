$(document).ready(function() {
    
    $("#btn-cree-historique").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-historique]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_historique,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    toastr.success("Nouvel historique enregistré avec succes");
                    //retrait du bouton "creer un nouvel historique"
                    $("#tr-valide").remove();

                    //s'il n'y a aucun historique à la base
                    if($(".row-historique td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-historique").remove();
                    }

                    //insert dans la table de l'historique cree
                    let date_debut = DateUsVersFr($("#serp_historique_production_date_debut_date").val());
                    let date_fin = DateUsVersFr($("#serp_historique_production_date_fin_date").val());
                    var row = $("<tr class='row-historique'>");
                    row.append($("<td>" + $("#serp_historique_production_id_of").find("option:selected").text() + "</td>"))
                        .append($("<td>" + date_debut + ' ' + $("#serp_historique_production_date_debut_time").val()  + "</td>"))
                        .append($("<td>" + date_fin + ' ' + $("#serp_historique_production_date_fin_time").val()  + "</td>"))
                        .append($("<td>" + $("#serp_historique_production_id_intervenant").find("option:selected").text() + "</td>"))
                        .append($("<td>" + $("#serp_historique_production_quantite_debut").val() + "</td>"))
                        .append($("<td>" + $("#serp_historique_production_quantite_fin").val() + "</td>"))
                        .append($("<td><button class='btn btn-primary edite-historique' data-id='" + id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-historique' data-id='" + id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);

                    //retour du bouton "creer un nouvel historique"
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='8'><button class='btn btn-primary' id='cree-historique'>Créer un nouvel historique</button></td></tr>"));

                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-historique").modal("hide");
                    $("#serp_historique_production_id_of").val($("#serp_historique_production_id_of option:first").val());
                    $("#serp_historique_production_date_debut_date").val("");
                    $("#serp_historique_production_date_debut_time").val("");
                    $("#serp_historique_production_date_fin_date").val("");
                    $("#serp_historique_production_date_fin_time").val("");
                    $("#serp_historique_production_id_intervenant").val($("#serp_historique_production_id_intervenant option:first").val());
                    $("#serp_historique_production_quantite_debut").val();
                    $("#serp_historique_production_quantite_fin").val();
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

    //retire les message d'erreur d'un champ (si present)
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