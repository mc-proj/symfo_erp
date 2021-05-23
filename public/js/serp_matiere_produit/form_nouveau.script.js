$(document).ready(function() {
    
    $("#btn-cree-matiere-produit").on("click", function() {

        loader(true);
        let form = $("[name=form-cree-matiere-produit]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_matiere_produit,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    if(erreurs == "securite double") {
                        toastr.error("Erreur: Cette matière a deja été liée à ce produit")
                    } else {
                        let id = erreurs;
                        toastr.success("Nouvelle matière liée avec succes");
                        //retrait du bouton "lier une nouvelle matiere"
                        $("#tr-valide").remove();
                        //insert dans la table de la matiere liee
                        var row = $("<tr class='row-matiere-produit'>");
                        row.append($("<td>" + $("#serp_matiere_produit_id_matiere").find("option:selected").text() + "</td>"))
                            .append($("<td>" + $("#serp_matiere_produit_quantite_matiere").val() + "</td>"))
                            .append($("<td><button class='btn btn-primary edite-matiere-produit' data-id='" + id + "'>Editer</button></td>"))
                            .append($("<td><button class='btn btn-danger efface-matiere-produit' data-id='" + id + "'>Effacer</button></td>"))
                            .append("</tr>");
                        $("#body-info").last().append(row);
                        //retour du bouton "lier nouvelle matiere"
                        let row_bouton_save = $("<tr id='tr-valide'>");
                        row_bouton_save.append($("<td colspan='4'><button class='btn btn-primary' id='ajoute-matiere-produit'>Ajouter une matière</button></td></tr>"));

                        $("#body-info").last().append(row_bouton_save);
                        $("#modale-formulaire-matiere_liee").modal("hide");
                        $("#serp_matiere_produit_quantite_matiere").val("");
                        $("#serp_matiere_produit_id_matiere").val($("#serp_matiere_produit_id_matiere option:first").val());
                    }
                } else {

                    $(".texte-rouge").each(function() {

                        $(this).remove();
                    });

                    toastr.error("Erreur: un des champs fourni est incorrect");
                    //affichage des erreurs aux champs concernés
                    for(let nom in erreurs) {
    
                        $("#serp_matiere_produit_" + nom).prev().append('<div class="texte-rouge" id="erreur_matiere_produit_' + nom + '"><span class="badge bg-danger">Erreur</span> ' + erreurs[nom] + '</div>');
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

            id_base = id_base.split("serp_matiere_produit_");
            $("#erreur_matiere_produit_" + id_base[1]).remove();
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