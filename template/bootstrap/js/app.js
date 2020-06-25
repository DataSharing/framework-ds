$(document).ready(function () {
    $(".zoneClick").click(function () {
        window.location = $(this).find("a").attr("href");
        return false;
    });

    var btncopy = document.querySelector('.js-copy');
    if(btncopy) {
        btncopy.addEventListener('click', docopy);
    }

    setTimeout(function () {
        $(".notif").remove();
    }, 15000);


    tinymce.init({
        selector: 'textarea.editeur',
        plugins: "code",
        valid_children: "+body[style]"
    });
    $('[data-toggle="tooltip"]').tooltip();
});

function NotifClose(i) {
    $('.notif'+i).remove();
}

function logs(recherche = '')
{
    var id = $('#id').val();
    var controller = $('#controller').val();
    var par_page = $("#par_page").val();
    var col = $('#col').val();

    if (typeof recherche.value === 'undefined')
    {
        v_recherche = '';
    }else{
        v_recherche = recherche.value;
    }

    $("#par_page").val(parseInt(par_page)*2);

    $.ajax({
        async: false,
        type: "POST",
        url: "ajax/logs.php",
        data: "logs&controller=" + controller + "&id=" + id + "&par_page=" + par_page + "&recherche=" + v_recherche + "&col=" + col,
        success: function(html) {
            $("#logs").html(html);
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

function docopy() {

    // Cible de l'élément qui doit être copié
    var target = this.dataset.target;
    var fromElement = document.querySelector(target);
    if(!fromElement) return;

    // Sélection des caractères concernés
    var range = document.createRange();
    var selection = window.getSelection();
    range.selectNode(fromElement);
    selection.removeAllRanges();
    selection.addRange(range);

    try {
        // Exécution de la commande de copie
        var result = document.execCommand('copy');
        if (result) {
            // La copie a réussi
            alert('Copié !');
        }
    }
    catch(err) {
        // Une erreur est surevnue lors de la tentative de copie
        alert(err);
    }

    // Fin de l'opération
    selection = window.getSelection();
    if (typeof selection.removeRange === 'function') {
        selection.removeRange(range);
    } else if (typeof selection.removeAllRanges === 'function') {
        selection.removeAllRanges();
    }
}