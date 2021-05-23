$(document).ready(function() {
    
    $("#btn-cree-qualite").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-qualite]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_qualite,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);

                if(typeof(response.date) != "undefined") {

                    toastr.success("Nouvel controle qualité enregistré avec succes");
                    //retrait du bouton "creer un nouvel intervenant"
                    $("#tr-valide").remove();

                    //s'il n'y a aucun controle à la base
                    if($(".row-qualite td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-qualite").remove();
                    }

                    //insert dans la table du control qualite cree
                    var row = $("<tr class='row-qualite'>");
                    row.append($("<td>" + response.date + "</td>"))
                        .append($("<td>" + $("#serp_controle_qualite_of_id").find("option:selected").text() + "</td>"))
                        .append($("<td>" + $("#serp_controle_qualite_id_intervenant").find("option:selected").text() + "</td>"))
                        .append($("<td>" + $("#serp_controle_qualite_quantite_controlee").val() + "</td>"))
                        .append($("<td><button class='btn btn-primary edite-qualite' data-id='" + response.id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-qualite' data-id='" + response.id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);

                    //retour du bouton "creer un nouveau controle qualite
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='7'><button class='btn btn-primary' id='cree-qualite'>Créer un nouveau controle qualité</button></td></tr>"));

                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-qualite").modal("hide");
                    $("#serp_controle_qualite_quantite_controlee").val("");
                    $("#serp_controle_qualite_id_intervenant").val($("#serp_controle_qualite_id_intervenant option:first").val());
                    $("#serp_controle_qualite_of_id").val($("#serp_controle_qualite_of_id option:first").val());
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_controle_qualite_" + nom).prev().append('<div class="texte-rouge" id="erreur_qualite_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');
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

            id_base = id_base.split("serp_controle_qualite_");
            $("#erreur_controle_qualite_" + id_base[1]).remove();
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