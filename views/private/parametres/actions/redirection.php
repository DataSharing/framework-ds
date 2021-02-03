<script LANGUAGE="JavaScript">
    window.setTimeout("document.form.time.value='0';location=('<?php echo $this->echoRedirect('parametres/fichier/maj');?>');",3000);
</script>
<FORM METHOD=POST name="form" style="margin:5em auto;">
    <INPUT TYPE="text" NAME="time" size="1" style="border: 0; background-color: #FFFFFF; font-size: 0pt; background-repeat: repeat; background-attachment: scroll; background-position: 0% 50%"/>
    <center>
        <a class="btn btn-primary" style="margin-top:12px;" href="#">
            <i class="icon icon-refresh icon-spin"></i>
            <b>Modification du contenu en cours ...</b>
        </a></br>
        <img src="<?php echo $this->base_url; ?>template/bootstrap/images/engrenage.gif" style="margin-top:7em;opacity:0.1;width: 21em;" />
    </center>
</FORM>
