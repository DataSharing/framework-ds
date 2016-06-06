$(document).ready(function(){
    setTimeout(function() {
      $(".notif").remove();
    }, 7000);
    $('input[name="all"]').bind('click', function(){
    var status = $(this).is(':checked');
    $('input[type="checkbox"]', $(this).parent('li')).attr('checked', status);
    });
});
  $(function() {
    $( "#date_echeance" ).datepicker({ dateFormat: 'dd-mm-yy' });
  });

$(function() {
    $( "#date_echeance_modifier" ).datepicker({ dateFormat: 'dd-mm-yy' });
  });

function NotifOk(texte){
    jQuery('#notif-block').append('<div id=notif class=notif><p>'+ texte +'<span style="" class="glyphicon glyphicon-ok notif-ok"></span></p></div>');
    setTimeout(function() {
      $(".notif").remove();
    }, 5000);

}

function NotifClose(){
    $(".notif").remove();
}