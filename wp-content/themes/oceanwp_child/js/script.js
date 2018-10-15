var $ = jQuery.noConflict();
var domain = 'http://213.32.18.30/cites';
var taxonomy = {
    "KINGDOM": {
        "fr": "Règne",
        "en": "Kingdom"
    },
    "PHYLUM": {
        "fr": "Embranchement",
        "en": "Phylum"
    },
    "CLASS": {
        "fr": "Classe",
        "en": "Class"
    },
    "ORDER": {
        "fr": "Ordre",
        "en": "Order"
    },
    "FAMILY": {
        "fr": "Famille",
        "en": "Family"
    },
    "GENUS": {
        "fr": "Genre",
        "en": "Genus"
    },
    "SPECIES": {
        "fr": "Espèce",
        "en": "Species"
    },
    "SUBSPECIES": {
        "fr": "Sous-espèce",
        "en": "Subspecies"
    }
}

$(document).ready(function() {

    // filter action, home page
    var $ = jQuery.noConflict();

    // gérer le back fiche taxon -> filtre (sauvegarder les parametres de recherche et les relancer )
    // recherche simple
    var keyword = $('#searchVal').val();
    if (keyword) {
        filter();
    } else {
        // recherche avancée
        $('.advInput').each(function() {
            if ($(this).val()) {
                filter();
                return;
            }
        });
    }

    $('#searchVal').keypress(function(e) {
        keyword = $('#searchVal').val();
        if ((e.which == 13) && (keyword)) {
            filter();
        }
    });

    $('#advsearchBtn').click(function() {
        filter();
    });

    $('.advInput').keypress(function(e) {
        if (e.which == 13) {
            filter();
        }
    });


    $('#advsearchMaskBtn').click(function() {
        $('.advancedSearch').addClass('hidden');
        $('.generalSearch').removeClass('hidden');
        $('.advInput').val('');

    });

    // autocomplete on origin field (country)
    $('#origin').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: domain + '/wp-content/themes/oceanwp_child/pays.php',
                dataType: "json",
                data: {
                    'query': document.getElementById('origin').value,
                    'lang': $('#language').val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
        onSelect: function(suggestion) {

        }
    });

});

function filter() {
    var $ = jQuery.noConflict();
    var keyword = $('#searchVal').val();
    var params = {};
    params['type'] = 'simple';
    params['search'] = keyword;
    params['origin'] = $('#origin').val();
    params['body'] = $('#body option:selected').val();
    params['language'] = $('#language').val();
    var caracteristics = [];
    $('input[name="caract"]:checked').each(function() {
        caracteristics.push(this.value);
    });
    params['caract'] = caracteristics

    if ((params['language'] != 'fr-FR') || (!params['origin'])) {
        ajaxCall(params);
    } else {
        $.ajax({
            url: domain + '/wp-content/themes/oceanwp_child/paysTraduction.php',
            dataType: "json",
            data: {
                'query': document.getElementById('origin').value,
            },
            success: function(data) {
                if (data[0]) {
                    params['origin'] = data[0];

                } else {
                    params['origin'] = 'null'
                }
                ajaxCall(params);
            },
            beforeSend: function() {
                $('#results').find('.taxon-post').remove();
                $(document).scrollTop();
                $('#results').html('<div class="page-content" id="loader"><img src="' + domain + '/wp-content/themes/oceanwp_child/res/ajax-load.gif"></div>');
            }
        });

    }
}

function ajaxCall(params) {
    var $ = jQuery.noConflict();
    var ln = localStorage.getItem('lang');
    var url;
    if (ln == 'fr-FR') {
        url = 'wp-admin/admin-ajax.php';
    } else {
        url = '../../wp-admin/admin-ajax.php';
    }

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            'params': params,
            'action': 'taxons_search'
        },
        success: function(response) {
            var list = JSON.parse(response);
            $('#results').html('');

            if (list.length == 0) {
                var message = "<p class='textResults'>Pas d'espèces pour les critères sélectionnés.</p>"
                if (ln != 'fr-FR') { message = "<p class='textResults'>No species for selected criterias.</p>" }
                $('#results').html(message);
                return;
            }
            for (var i = 0; i < list.length; i++) {
                var obj = list[i];
                var lang = obj["lang"];
                var name_FR = obj["Name_FR"];
                var picture = obj["path"];
                var scName = obj["scName"];
                var name_EN = obj["Name_EN"];
                var rank = obj["rank"];
                var lien = obj["lien"];
                var cites = obj["CITES"];
                var html;
                if (lang == 'fr-FR') {
                    html = generateFrTemplate(name_EN, picture, scName, name_FR, lien, rank, cites);
                } else {
                    html = generateEnTemplate(name_EN, picture, scName, name_FR, lien, rank, cites);
                }
                if (rank === 'FAMILY') {
                    $('#results').prepend(html);
                } else {
                    $('#results').append(html);
                }

            }

        },
        beforeSend: function() {
            $('#results').find('.taxon-post').remove();
            $(document).scrollTop();
            var message = 'Loading results...';
            if (ln == 'fr-FR') { message = 'Chargement des résultats...' }
            $('.textResults').html('<div class="page-content" id="loader">&nbsp;&nbsp;' + message + '</div>');
        }
    });

}

function advancedFilter() {
    var $ = jQuery.noConflict();
    var params = {};
    params['type'] = 'advanced';
    params['origin'] = $('#origin').val();
    params['body'] = $('#body').val();
    params['caract'] = $('#caract').val();
    ajaxCall(params);
}

function generateEnTemplate(name_EN, picture, scName, name_FR, lien, rank, cites) {

    var citesElem = getCitesElement(cites, 'en', rank, false);
    var template = '<div class="taxon-post"> <a href="' + lien + '?lang=en' + '"><img src="' + picture + '" class="taxon-img">  <span class="taxNameEn">' + name_EN;
    if (rank == "FAMILY") {
        template += ' <i>(family)</i>';
    }
    template += '</span><br/><span>' + scName + '</span><br/>';
    template += '<span>' + name_FR + '</span>';
    template += citesElem;
    template += '</a></div> ';

    return template;

}

function generateFrTemplate(name_EN, picture, scName, name_FR, lien, rank, cites) {

    var citesElem = getCitesElement(cites, 'fr', rank, false);

    var template = '<div class="taxon-post"> <a href="' + lien + '"><img src="' + picture + '" class="taxon-img"><span class="taxNameEn">' + name_FR;
    if (rank == "FAMILY") {
        template += ' <i>(famille)</i>';
    }
    template += '</span><br/>';

    template += '<span>' + scName + '</span><br/>';
    template += '<span>' + name_EN + '</span>';
    template += citesElem;
    template += '</a></div> ';

    return template;
}

function getCitesElement(cites, lang, rank, detail) {
    var cssClass;
    var citesMsg;
    var rankval = '';
    var penality = '';
    var summary = '';

    if (rank) {
        rank = rank.toUpperCase();
        if (lang == 'fr') {
            rankval = taxonomy[rank]['fr'];
        } else {
            rankval = taxonomy[rank]['en'];
        }
    }

    var ranklabel = rankval.toLowerCase();

    switch (cites) {
        case 'I':
            cssClass = "cites_appendix a_I";
            if (lang == 'fr') {
                if (((rankval == 'Espèce') || (rankval == 'Sous-espèce')) || (detail==false)) {
                    citesMsg = rankval + " menacée d'extinction, commerce international illégal.";
                } else {
                    citesMsg = "Les espèces appartenant à ce(cette) " + ranklabel + " sont menacées d'extinction, leur commerce international est illégal.";
                }
                penality = "En fonction du pays où le spécimen a été identifié et du type d'infraction, les sanctions peuvent aller d'une amende à plusieurs années de prison, ainsi que la confiscation du spécimen ou de l'objet issu du spécimen.";
                summary = "Les espèces inscrites à l'annexe I de la CITES sont menacées d'extinction et leur commerce est par défaut interdit. Cependant, leur commerce peut être autorisé dans des conditions exceptionnelles - pour la recherche scientifique, par exemple. Quand c'est le cas, un permis d'exportation (ou un certificat de réexportation) et un permis d'importation sont délivrés.";

            } else {
                // lang = en
                if (((rankval == 'Species') || (rankval == 'Subspecies')) || (detail==false)){
                    citesMsg = rankval + ' threatened with extinction, international trade is illegal.';
                } else {
                    citesMsg = "Species belonging to " + ranklabel + " are threatened with extinction, their international trade is illegal.";
                }
                penality = "Depending on the country where the specimen was identified and the type of offense, the penalties may range from a fine to several years in prison, as well as the confiscation of the specimen or object from the specimen.";
                summary = "CITES Appendix I species are threatened with extinction and their trade is by default prohibited. However, their trade may be allowed under exceptional conditions - for scientific research, for example. When this is the case, an export permit (or a re-export certificate) and an import permit are issued.";


            }
            break;
        case 'II':
            cssClass = "cites_appendix a_II";
            if (lang == 'fr') {
                if (((rankval == 'Espèce') || (rankval == 'Sous-espèce')) || (detail==false)) {
                    citesMsg = rankval + ' vulnérable, commerce international réglementé.';
                } else {
                    citesMsg = 'Les espèces appartenant à  ce (cette) ' + ranklabel + ' sont vulnérables, leur commerce international est réglementé.';
                }
                penality = "En fonction du pays où le spécimen a été identifié et du type d'infraction, les sanctions peuvent aller d'une amende à plusieurs années de prison, ainsi que la confiscation du spécimen ou de l'objet issu du spécimen.";
                summary = "Les espèces inscrites à l'annexe II sont celles qui, bien que n'étant pas nécessairement menacées actuellement d'extinction, pourraient le devenir si le commerce de leurs spécimens n'était pas étroitement contrôlé. Le commerce international des spécimens des espèces inscrites à l'Annexe II peut être autorisé. Quand c'est le cas, un permis d'exportation ou un certificat de réexportation est délivré ; un permis d'importation n'est pas nécessaire.";

            } else {
                // lang = en
                if (((rankval == 'Species') || (rankval == 'Subspecies')) || (detail==false)){
                    citesMsg = 'Vulnerable ' + rankval + ', international trade is regulated.';
                } else {
                    citesMsg = 'Species belonging to ' + ranklabel + ' are vulnerable, their international trade is regulated.';

                }
                penality = "Depending on the country where the specimen was identified and the type of offense, the penalties may range from a fine to several years in prison, as well as the confiscation of the specimen or object from the specimen.";
                summary = "The species listed in Annex II are those which, although not necessarily threatened with extinction, could become so if trade in their specimens is not closely controlled. International trade in specimens of Appendix-II species may be permitted. When this is the case, an export permit or a re-export certificate is issued; an import permit is not necessary.";

            }
            break;
        case 'III':
            cssClass = "cites_appendix a_III";
            if (lang == 'fr') {

                if (((rankval == 'Espèce') || (rankval == 'Sous-espèce')) || (detail==false)) {
                    citesMsg = rankval + ' protégée par au moins un pays sur son territoire, commerce international réglementé.';
                } else {
                    citesMsg = 'Les espèces appartenant à  ce (cette) ' + ranklabel + ' sont protégées par au moins un pays sur son territoire, leur commerce international est réglementé.';
                }
                penality = "En fonction du pays où le spécimen a été identifié et du type d'infraction, les sanctions peuvent aller d'une amende à plusieurs années de prison, ainsi que la confiscation du spécimen ou de l'objet issu du spécimen.";
                summary = "Les espèces inscrites à l'annexe III de la CITES sont des espèces inscrites à la demande d'une partie (pays) qui en réglemente déjà le commerce et qui a besoin de la coopération des autres parties pour en empêcher l'exploitation illégale ou non durable. Le commerce international des spécimens des espèces inscrites à cette annexe n'est autorisé que sur présentation des permis ou certificats appropriés.";
            } else {
                // lang = en 
                if (((rankval == 'Species') || (rankval == 'Subspecies')) || (detail==false)){
                    citesMsg = rankval + ' protected by at least one country within its territory, international trade is regulated.';
                } else {
                    citesMsg = 'Species belonging to ' + ranklabel + ' are protected by at least one country within its territory, their international trade is regulated.';
                }
                penality = "Depending on the country where the specimen was identified and the type of offense, the penalties may range from a fine to several years in prison, as well as the confiscation of the specimen or object from the specimen.";
                summary = "CITES Appendix III species are species listed at the request of a Party (country) that already regulates trade and needs the cooperation of other parties to prevent illegal or unsustainable exploitation or unsustainable. International trade in specimens of the species included in this Annex is permitted only on presentation of the appropriate permits or certificates.";
            }
            break;
    }

    var html;
    if (detail == false) {
        html = '<div class="row citesStatus"><div class="col-md-2 pict"><div class="' + cssClass + '"><span>' + cites + '</span></div></div><div class="col-md-8 citesMsg">' + citesMsg + '</div></div>';
    } else {
        html = '<div class="row citesDetails"><div class="col-md-1 pict"><div class="' + cssClass + '"><span>' + cites + '</span></div></div><div class="col-md-11 citesDetailsMsg">' + citesMsg + '</div></div>';
        html += '<div class="penality">' + penality + '</div>';
        html += '<div class="summary">' + summary + '</div>';
    }

    return html;
}

function gettaxonFamilyhtml(lang, rank) {
    var rankval = '';
    var hierarchy = '<div>';
    if (rank) {
        rank = rank.toUpperCase();
        if (lang == 'fr') {
            rankval = taxonomy[rank]['fr'];
            hierarchy = "Rang du taxon : Règne / Embranchement / Classe / Ordre / Famille / Genre / Espèce / Sous-espèce";
        } else {
            rankval = taxonomy[rank]['en'];
            hierarchy = "Taxon rank : Kigdom / Phylum / Class / Order / Family / Genus / Species / Subspecies";
        }
    }
    return hierarchy + '</div>';

}