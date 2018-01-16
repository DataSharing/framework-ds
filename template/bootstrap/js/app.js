$(document).ready(function () {
    $(".zoneClick").click(function () {
        window.location = $(this).find("a").attr("href");
        return false;
    });

    setTimeout(function () {
        $(".alert").remove();
    }, 7000);

    setTimeout(function () {
        $(".notif").remove();
    }, 15000);

    $('#date_debut').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#date_fin').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    tinymce.init({
        selector: 'textarea.editeur',
        plugins: "code",
        valid_children: "+body[style]"
    });
    $('[data-toggle="tooltip"]').tooltip();

    viewLogiciels();
    etudiants();
});

function navigationSemaine(select,id_type){
    var currentLocation =  document.location.href;
    var valeur = select.value;
    var res = currentLocation.split("semaine/");
    if(typeof res[1] == "undedined" || res[1] == null){
        var now     = new Date();
        var annee   = now.getFullYear();
        var mois    = now.getMonth() + 1;
        var jour    = now.getDate();
        var valeur  = jour+"-"+mois+"-"+annee;
        var typeUrl = "type="+id_type;
    }else{
        var explodeDateType = res[1].split("?");
        var typeUrl = explodeDateType[1];
    }
    window.location.replace(res[0]+"semaine/"+valeur+"?"+typeUrl);
}

function ajouterChamp() {
    var nbchamps = $('#nb-champs').val();
    var nbajout = $('#nb-ajout').val();
    var plus = parseInt(nbchamps) + parseInt(nbajout);
    $('#nb-champs').val(plus);
    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/modeles.php",
        data: "nb-champs=" + nbchamps + "&nb-ajout="+nbajout,
        success: function (html) {
            $("#champ").html(html);
        }
    });
}

/* VIEW LOGICIELS */

function viewLogiciels(){
    var logiciel = $('#logiciels').val();
    var ressource = $('#ressource').val();
    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/logiciels.php",
        data: "action=view&logiciel=" + logiciel + "&ressource="+ressource,
        success: function (html) {
            $("#view_logiciels").html(html);
        }
    });
}

function ajouterLogiciel() {
    var logiciel = $('#logiciels').val();
    var ressource = $('#ressource').val();
    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/logiciels.php",
        data: "action=ajouter&logiciel=" + logiciel + "&ressource="+ressource,
        success: function (html) {
            $("#view_logiciels").html(html);
        }
    });
}

function supprimerLogiciel(logiciel) {
    var ressource = $('#ressource').val();
    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/logiciels.php",
        data: "action=supprimer&logiciel=" + logiciel + "&ressource="+ressource,
        success: function (html) {
            $("#view_logiciels").html(html);
        }
    });
}

/* END VIEW LOGICIELS */

function checkDoublons(nom) {
    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/modeles.php",
        data: "modele=" + nom.value,
        success: function (html) {
            $("#check").html(html);
        }
    });
}

function NotifClose(i) {
    $('.notif'+i).remove();
}

function Ressources() {
    var type = $('#types').val();
    var idR = $('#idressource').val();
    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/ressources.php",
        data: "type=" + type + "&selected=" + idR,
        success: function (html) {
            $("#ressources").html(html);
        }
    });
}

function Droits() {
    var id = $('#id_groupe').val();
    var ctrl = $('#controller').val();
    var lecture = $('#lecture').val();
    var modification = $('#modification').val();
    var suppression = $('#suppression').val();

    $.ajax({
        async: false,
        type: "POST",
        url: "./ajax/droits.php",
        data: "controller=" + ctrl + "&id_groupe=" + id + "&l=" + lecture + "&m=" + modification + "&s=" + suppression,
        success: function (html) {
            $("#tab_acces").html(html);
        }
    });
}


function DroitsType() {
    var id = $('#id_groupe').val();
    var ctrl = $('#type').val();

    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/droits.php",
        data: "type=" + ctrl + "&id_groupe=" + id,
        success: function (html) {
            $("#tab_acces_type").html(html);
        }
    })
}

function supprimerDroit(nom_type) {
    var id = $('#id_groupe').val();
    $.ajax({
        async: false,
        type: "POST",
        url: "../../ajax/droits.php",
        data: "nom_type=" + nom_type + "&id_groupe=" + id,
        success: function (html) {
            $("#tab_acces_type").html(html);
        }
    });
}

function cocherOuDecocherTout(cochePrincipale) {
    var coches = document.getElementById('tableau')
            .getElementsByTagName('input');
    for (var i = 0; i < coches.length; i++) {
        var c = coches[i];
        if (c.type.toUpperCase() == 'CHECKBOX' & c != cochePrincipale) {
            c.checked = cochePrincipale.checked;
        }
    }
    return true;
}

function checkMotif() {
    var statuts = $('#statuts').val();
    var motif = document.getElementById("motif");
    if (statuts == 4) {
        motif.style.display = "block";
    } else {
        motif.style.display = "none";
    }
}

function dropdown(id, nom, color) {
    var couleurs = document.getElementById("couleurs");
    var codeSelected = document.getElementById("codeSelected");
    couleurs.value = id;
    codeSelected.innerHTML = "<i class='fa fa-circle' style='color:#" + color + "' aria-hidden='true'></i> " + nom + " <span class='caret'></span>";
}

function autoCompleteDate()
{
    var debut = $('#date_debut').val();
    var heure_debut = $('#heure_debut').val();
    var heurePlusDemi = parseInt(heure_debut) + 0.5;
    $('#date_fin').val(debut);
    $('#heure_fin').val(heurePlusDemi);
}


function sLeft() {
    $('#btn-scroll-l').addClass("disabled");
    var valeurMargin = $('#scroll').css('margin-left');

    if (valeurMargin == "0px" || valeurMargin == "0" || valeurMargin > 0) {
    } else {
        $('#scroll').animate({
            marginLeft: "+=60em"
        }, "slow");
    }

    setTimeout(function () {
        $('#btn-scroll-l').removeClass("disabled");
    }, 1000);
}

function sRight(limite) {
    $('#btn-scroll-r').addClass("disabled");
    var valeurMargin = $('#scroll').css('margin-left');
    var numVM = parseInt(valeurMargin.replace('px', '')) * 0.063;
    var limiteCalc = limite - 100;

    if (-numVM < limiteCalc) {
        $('#scroll').animate({
            marginLeft: "-=60em"
        }, "slow");
    }

    setTimeout(function () {
        $('#btn-scroll-r').removeClass("disabled");
    }, 1000);
}

function etudiants(){
    $.ajax({
        async: false,
        type: "POST",
        url: "./ajax/etudiants.php",
        data: "etu=",
        success: function (html) {
            $("#noetus").html(html);
        }
    });
}

function ajouterEtu() {
    var noetu = $('#noetu').val();
    $('#noetu').val("");
    $.ajax({
        async: false,
        type: "POST",
        url: "./ajax/etudiants.php",
        data: "etu=" + noetu + "&action=ajouter",
        success: function (html) {
            $("#noetus").html(html);
        }
    });
}

function supprimerEtu(noetu) {
    $.ajax({
        async: false,
        type: "POST",
        url: "./ajax/etudiants.php",
        data: "etu=" + noetu + "&action=supprimer",
        success: function (html) {
            $("#noetus").html(html);
        }
    });
}