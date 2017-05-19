$(document).ready(function () {
    $(".zoneClick").click(function () {
        window.location = $(this).find("a").attr("href");
        return false;
    });

    setTimeout(function () {
        $(".notif").remove();
    }, 7000);

});

function NotifClose() {
    $('.notif').remove();
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
    })
}
