$(document).ready(function() {
    
    $("#btn-cree-intervenant").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-intervenant]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_intervenant,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    toastr.success("Nouvel intervenant enregistré avec succes");
                    //retrait du bouton "creer un nouvel intervenant"
                    $("#tr-valide").remove();

                    //s'il n'y a aucun intervenant à la base
                    if($(".row-intervenant td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-intervenant").remove();
                    }

                    //insert dans la table de l'intervenant cree
                    var row = $("<tr class='row-intervenant'>");
                    row.append($("<td>" + $("#serp_intervenant_nom").val() + "</td>"))
                        .append($("<td>" + $("#serp_intervenant_prenom").val() + "</td>"))
                        .append($("<td>" + $("#serp_intervenant_id_type_intervenant").find("option:selected").text() + "</td>"))
                        .append($("<td><button class='btn btn-primary edite-intervenant' data-id='" + id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-intervenant' data-id='" + id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);
                    //retour du bouton "creer un nouvel intervenant"
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='7'><button class='btn btn-primary' id='cree-intervenant'>Créer un nouvel intervenant</button></td></tr>"));

                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-intervenant").modal("hide");
                    $("#serp_intervenant_nom").val("");
                    $("#serp_intervenant_prenom").val("");
                    $("#serp_intervenant_id_type_intervenant").val($("#serp_intervenant_id_type_intervenant option:first").val());
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_intervenant_" + nom).prev().append('<div class="texte-rouge" id="erreur_intervenant_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');
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

            id_base = id_base.split("serp_intervenant_");
            $("#erreur_intervenant_" + id_base[1]).remove();
        }
    })

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