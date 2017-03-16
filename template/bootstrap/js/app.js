$(document).ready(function() {
    $(".zoneClick").click(function(){
         window.location=$(this).find("a").attr("href");
         return false;
    });

    setTimeout(function() {
      $(".notif").remove();
    }, 7000);

});

function NotifClose(){
	$('.notif').remove();
}


function Droits(){
    var id = $('#id_groupe').val();
    var ctrl = $('#controller').val();
    var lecture = $('#lecture').val();
    var modification = $('#modification').val();
    var suppression = $('#suppression').val();

    $.ajax({
        async : false,
        type : "POST",
        url  : "./ajax/droits.php",
        data: "controller=" + ctrl + "&id_groupe=" + id + "&l="+ lecture + "&m=" + modification + "&s="+ suppression,
        success: function(html){
            $("#tab_acces").html(html);
        }
    })
}
