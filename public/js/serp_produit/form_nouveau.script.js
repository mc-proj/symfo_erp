$(document).ready(function() {
    
    $("#btn-cree-produit").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-produit]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_produit,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    toastr.success("Nouveau produit enregistré avec succes");
                    //retrait du bouton "creer un nouveau produit"
                    $("#tr-valide").remove();

                    //s'il n'y a aucun produit à la base
                    if($(".row-produit td").length == 1) {
                        //on supprime le message qui informe de l'absence de données
                        $(".row-produit").remove();
                    }

                    //insert dans la table du produit cree
                    var row = $("<tr class='row-produit'>");
                    row.append($("<td>" + $("#serp_produit_nom").val() + "</td>"))
                        .append($("<td><button class='btn btn-primary bouton-matiere' data-id='" + id + "'>Matières</button></td>"))
                        .append($("<td><button class='btn btn-primary edite-produit' data-id='" + id + "'>Editer</button></td>"))
                        .append($("<td><button class='btn btn-danger efface-produit' data-id='" + id + "'>Effacer</button></td>"))
                        .append("</tr>");
                    $("#body-info").last().append(row);

                    //retour du bouton "creer un nouveau produit"
                    let row_bouton_save = $("<tr id='tr-valide'>");
                    row_bouton_save.append($("<td colspan='4'><button class='btn btn-primary' id='cree-produit'>Créer un nouveau produit</button></td></tr>"));    
                    
                    $("#body-info").last().append(row_bouton_save);
                    //on cache la modale et on reset le formulaire
                    $("#modale-formulaire-produit").modal("hide");
                    $("#serp_produit_nom").val("");
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_produit_" + nom).prev().append('<div class="texte-rouge" id="erreur_produit_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');
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

            id_base = id_base.split("serp_produit_");
            $("#erreur_produit_" + id_base[1]).remove();
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