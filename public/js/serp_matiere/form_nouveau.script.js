$(document).ready(function() {
    
    $("#btn-cree-matiere").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-matiere]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_matiere,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    toastr.success("Nouvelle matiere enregistrée avec succes");
                    //retrait du bouton "creer une nouvelle matiere
                    $("#tr-valide").remove();

                    //s'il n'y a aucune matiere à la base
                    if($(".row-matiere td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-matiere").remove();
                    }

                    //insert dans la table de la matiere cree
                    var row = $("<tr class='row-matiere'>");
                    row.append($("<td>" + $("#serp_matiere_nom").val() + "</td>"))
                        .append($("<td>" + $("#serp_matiere_prix").val() + "</td>")) //watch out...ou pas ?
                        .append($("<td>" + $("#serp_matiere_quantite_stock").val() + "</td>"))
                        .append($("<td>" + $("#serp_matiere_limite_basse_stock").val() + "</td>"))
                        .append($("<td><button class='btn btn-primary edite-matiere' data-id='" + id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-matiere' data-id='" + id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);
                    //retour du bouton "creer une nouvelle matiere"
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='7'><button class='btn btn-primary' id='cree-matiere'>Créer une nouvelle matiere</button></td></tr>"));

                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-matiere").modal("hide");
                    $("#serp_matiere_nom").val("");
                    $("#serp_matiere_prix").val("");
                    $("#serp_matiere_quantite_stock").val("");
                    $("#serp_matiere_limite_basse_stock").val("");
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_matiere_" + nom).prev().append('<div class="texte-rouge" id="erreur_matiere_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');
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

            id_base = id_base.split("serp_matiere_");
            $("#erreur_matiere_" + id_base[1]).remove();
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