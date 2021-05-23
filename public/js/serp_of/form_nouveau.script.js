$(document).ready(function() {
    
    $("#btn-cree-of").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-of]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_of,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    toastr.success("Nouvel ordre de fabrication enregistré avec succes");
                    //retrait du bouton "creer un nouvel of"
                    $("#tr-valide").remove();

                    //s'il n'y a aucun of à la base
                    if($(".row-of td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-of").remove();
                    }

                    //insert dans la table de l'of cree
                    let date_fr = dateUsaVersFr($("#serp_of_date_commande").val());
                    var row = $("<tr class='row-of'>");
                    row.append($("<td>" + $("#serp_of_id_client").find("option:selected").text() + "</td>"))
                        .append($("<td>" + $("#serp_of_quantite_commandee").val() + "</td>"))
                        .append($("<td>" + date_fr + "</td>"))
                        .append($("<td>" + $("#serp_of_machine_id").find("option:selected").text() + "</td>"))
                        .append($("<td><button class='btn btn-primary edite-of' data-id='" + id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-of' data-id='" + id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);
                    //retour du bouton "creer un nouvel of"
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='7'><button class='btn btn-primary' id='cree-of'>Créer un nouvel ordre de fabrication</button></td></tr>"));

                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-of").modal("hide");
                    $("#serp_of_quantite_commandee").val("");
                    $("#serp_of_id_client").val($("#serp_of_id_client option:first").val());
                    $("#serp_of_date_commande").val("");
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