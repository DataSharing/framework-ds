$(document).ready(function () {
    $(".zoneClick").click(function () {
        window.location = $(this).find("a").attr("href");
        return false;
    });

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