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