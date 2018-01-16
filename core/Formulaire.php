<?php
/**
 * Class Formulaire : regroupe quelque fonctionnalité pour l'utilisation de formulaire
 */
Class Formulaire extends Controller{

    Public $errors = array();

    function __construct() {
        parent::__construct();
        $this->load('core/Model','model');
    }
    
    /* Validation des données */

    public function validate($donnees) {
        $valid = true;
        foreach ($donnees as $donnee) {
            if(!isset($_POST[$donnee])){
                $valid = false;
                $this->errors[] = "Variable <b>$donnee</b> non défini";
            }
        }
        return $valid;
    }

    /**
     * Protection du formulaire
     * Requête préparée ou cette fonction
     * 
     * @param array $data
     * @return array
     */
    public function ProtectionFormulaire($data = array(),$default = array()) {
        if (is_array($data)) {
            foreach ($data AS $cle => $valeur) {
                if (is_array($data[$cle])) {
                    $data[$cle] = $this->ProtectionFormulaire($data[$cle]);
                } else {
                    if (is_numeric($valeur)) {
                        //cast pour les nombres
                        $data[$cle] = intval($valeur);
                    } else {
                        //protection des chaines
                        $data[$cle] = htmlspecialchars($valeur);
                    }
                }
            }
        } else {
            $data = htmlspecialchars($data);
        }

        //Valeur par defaut
        if(count($default) >= 1 ){
            foreach($default as $key=>$value){
                if(!isset($data[$key])){
                    $data[$key] = $value;
                }
            }
        }
        return $data;
    }
    
    /**
     * Création d'un INPUT HTML
     * @param string $name
     * @param string $type
     * @param string $placeholder
     * @param string $error
     * @param string $value
     * @param string $pattern
     * @param string $option
     */
    public function input($name,$type,$placeholder,$error = '',$value = '', $pattern = "[A-Za-z0-9]*",$option = 'required'){
        $input2 = '';
        $input3 = '';
        if(!$pattern == ''){
            $input2 = 'pattern="'.$pattern.'" ';
        }
        if(!$error == ''){
            $input3 = 'x-moz-errormessage="'.$error.'" ';
        }
        $input1 = '<input '
        . 'type="'.$type.'" '
        . 'id="'.$name.'" '
        . 'name="'.$name.'" ' 
        . 'placeholder="'.$placeholder.'" '
        . 'class="form-control" '
        . 'value="'.$value.'" '
        . $input2
        . $input3
        . $option
        . '/>';
        echo $input1;
    }

    /**
     * Création d'un INPUT GROUP HTML
     * @param string $name
     * @param string $type
     * @param string $placeholder
     * @param string $error
     * @param string $value
     * @param string $class
     * @param string $pattern
     * @param string $option
     [A-Za-z0-9 ]*
     */
    public function inputGroup($name,$type,$placeholder,$error = '',$value = '', $class = "form-control", $pattern = "",$option = ''){
        $input2 = '';
        $input3 = '';
        if(!$pattern == ''){
            $input2 = 'pattern="'.$pattern.'" ';
        }
        if(!$error == ''){
            $input3 = 'x-moz-errormessage="'.$error.'" ';
        }
        $data['input'] = '<input '
        . 'type="'.$type.'" '
        . 'id="'.$name.'" '
        . 'name="'.$name.'" ' 
        . 'placeholder="'.$placeholder.'" '
        . 'class="'.$class.'" '
        . 'value="'.$value.'" '
        . $input2
        . $input3
        . $option
        . '/>';
        $data['titre'] = $placeholder;
        $this->view('app/inputs/input.group',$data);
    }
    
    /**
     * Création d'un INPUT HTML
     * Version améliorée de $this->input(...)
     * @param array $options
     */
    public function inputTab($options = array()){
        $optionsInput = '';
        $openInput = '<input ';
        foreach($options as $key=>$option){
            $opt = $key."='".$option."' ";
            $optionsInput = $optionsInput.$opt;
        }
        $closeInput = ' />';
        $input = $openInput.$optionsInput.$closeInput;
        echo $input;
    }
    
    /**
     * Création d'un BUTTON HTML
     * @param string $name
     * @param string $text
     * @param string $value
     * @param string $class
     * @param string $option
     [A-Za-z0-9 ]*
     */
    public function btn($name,$text, $class = "btn btn-default", $option = ''){
        $btn = '<button '
        . 'type="submit" '
        . 'id="'.$name.'" '
        . 'name="submit" ' 
        . 'class="'.$class.'" '
        . 'value="'.$name.'" '
        . $option
        . '>'.$text.'</button>';
        echo $btn;
    }

    /**
     * Création d'un BUTTON HTML MODAL
     * @param string $name
     * @param string $text
     * @param string $value
     * @param string $class
     * @param string $option
     [A-Za-z0-9 ]*
     */
    public function btnModal($name,$text, $class = "btn btn-default", $target = '',$option = ""){
        $btn = '<button '
        . 'type="button" '
        . 'id="'.$name.'" '
        . 'name="submit" ' 
        . 'class="'.$class.'" '
        . 'value="'.$name.'" '
        . 'data-toggle="modal" '
        . 'data-target ="'.$target.'" '
        . $option
        . '>'.$text.'</button>';
        echo $btn;
    }

    /**
     * Afficher la date au format FR
     * @param date $date
     * @param string $affichage
     * @return string
     */
    public function afficher_date($date, $affichage = 'date'){
        $date_sans_time = explode(' ',$date);
        if($affichage == 'date'){
            if($date == '0000-00-00'){
                return '0000-00-00';
            }else{
                $datetimeformat = new DateTime($date_sans_time[0]);
                return $datetimeformat->format('d-m-Y');
            }
        }elseif($affichage == 'dateheure'){
            $datetimeformat = new DateTime($date);
            return $datetimeformat->format('d-m-Y H:i');
        }
    }
    
    /**
     * Retourne une pagination (CSS Bootstrap)
     * 
     * @param string $table
     * @param int $page
     * @param int $par_page
     * @param array $where
     * @param string $operateur
     * @return string
     */
    public function pagination($table = '',$page,$par_page,$where = array(),$operateur = NULL){
        echo "<div class='container'>";
            echo "<div class='col-md-12'>";
                echo "<ul class='pagination pagination-sm'>";
                    $this->model->table = $table;
                    $total_records = $this->model->count($where,$operateur); 
                    $total_pages = ceil($total_records / $par_page); 
                    if($total_records <= $par_page){return '';}

                    for ($i=1; $i<=$total_pages; $i++) { 
                        echo "<li ";
                            if($page == $i){
                                echo "class='active'";
                            }
                        echo ">";
                            $url = str_replace('/?p=','',$_SERVER['REQUEST_URI']);
                            echo "<a href='".$this->echoRedirect($url.'?page='.$i)."'>".$i."</a>";
                        echo "</li>";
                    }   
               echo "</ul>";
            echo "</div>";
       echo "</div>";
    }
}