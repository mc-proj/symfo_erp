$(document).ready(function() {

    $("#btn-edition-qualite").on("click", function() {

        loader(true);
        let form = $("[name=form-edition-qualite]");
        let form_data = form.serializeObject();
        $.ajax({
            type: "POST",
            url: route_post_edite_qualite,
            dataType: "json",
            data: form_data,
            success: function(response) {

                loader(false);
                let erreurs = JSON.parse(response);

                if(typeof(erreurs) != "object") {

                    let id = erreurs;
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(3).text($("#serp_controle_qualite_quantite_controlee").val());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(2).text($("#serp_controle_qualite_id_intervenant").find("option:selected").text());
                    $('*[data-id="' + id + '"]').parent().parent().children().eq(1).text($("#serp_controle_qualite_of_id").find("option:selected").text());
                    $("#modale-formulaire-qualite").modal("hide");
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

    $(".form-control").on("click", function() {

        let id_base = $(this).attr("id");

        if(typeof(id_base) != "undefined") {

            id_base = id_base.split("serp_controle_qualite_");
            $("#erreur_qualite_" + id_base[1]).remove();
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