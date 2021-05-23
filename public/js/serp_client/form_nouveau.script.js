$(document).ready(function() {
    
    $("#btn-cree-client").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-client]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_client,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    toastr.success("Nouveau client enregistré avec succes");
                    //retrait du bouton "creer un nouveau client"
                    $("#tr-valide").remove();
                    
                    //s'il n'y a aucun client à la base
                    if($(".row-client td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-client").remove();
                    }

                    //insert dans la table du client cree
                    var row = $("<tr class='row-client'>");
                    row.append($("<td>" + $("#serp_client_nom").val() + "</td>"))
                        .append($("<td>" + $("#serp_client_adresse").val() + "</td>"))
                        .append($("<td>" + $("#serp_client_ville").val() + "</td>"))
                        .append($("<td>" + $("#serp_client_code_postal").val() + "</td>"))
                        .append($("<td>" + $("#serp_client_Pays").find("option:selected").text() + "</td>"))
                        .append($("<td><button class='btn btn-primary edite-client' data-id='" + id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-client' data-id='" + id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);
                    //retour du bouton "creer un nouveau client"
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='7'><button class='btn btn-primary' id='cree-client'>Créer un nouveau client</button></td></tr>"));

                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-client").modal("hide");
                    $("#serp_client_nom").val("");
                    $("#serp_client_adresse").val("");
                    $("#serp_client_ville").val("");
                    $("#serp_client_code_postal").val("");
                    $("#serp_client_Pays").val("FR");
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_client_" + nom).prev().append('<div class="texte-rouge" id="erreur_client_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');
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

            id_base = id_base.split("serp_client_");
            $("#erreur_client_" + id_base[1]).remove();
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