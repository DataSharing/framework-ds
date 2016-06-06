$('#ModalModifier').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var titre = button.data('titre')
  var description = button.data('description')
  var echeance = button.data('echeance')

  var modal = $(this)
  modal.find('.modal-body #idnote').val(id)
  modal.find('.modal-body #titre_modifier').val(titre)
  modal.find('.modal-body #description_modifier').val(description)
  modal.find('.modal-body #date_echeance_modifier').val(echeance)
})

$('#ModalSupprimerTuile').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')

  var modal = $(this)
  modal.find('.modal-body #idnote_supprimer').val(id)
})

function etatvolet(link) {
        var lienhref = link.href;
        var explode = lienhref.split("#");
        if(explode[1] == "volet"){
                document.getElementById("a_close").href = "#volet_clos";
                document.getElementById("a_volet").href = "#volet_clos";
        }else{
                document.getElementById("a_close").href = "#volet";
                document.getElementById("a_volet").href = "#volet";
        }
}
