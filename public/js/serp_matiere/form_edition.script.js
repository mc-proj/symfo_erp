$(document).ready(function() {

    $("#btn-edition-matiere").on("click", function() {

        loader(true);
        let form = $("[name=form-edition-matiere]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_edite_matiere,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(0).text($("#serp_matiere_nom").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(1).text($("#serp_matiere_prix").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(2).text($("#serp_matiere_quantite_stock").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(3).text($("#serp_matiere_limite_basse_stock").val());
                    $("#modale-formulaire-matiere").modal("hide");
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