<?php

Class Formulaire extends Controller{
    function __construct() {
        parent::__construct();
        $this->load('core/Model','model');
    }
    
    public function ProtectionFormulaire($data) {
        if (is_array($data)) {
            foreach ($data AS $cle => $valeur) {
                if (is_array($data[$cle])) {
                    $data[$cle] = ProtectionFormulaire($data[$cle]);
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
        return $data;
     }
    
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
        . '/></br>';
        echo $input1;
    }
    
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
    
    public function autocompletion($get){
        $array = array();
        $term = $get;
        $this->model->table = "villes";
        $where = array('ville_nom'=>"%".$term."%");
        $villes = $this->model->lecture('*',$where);
        foreach($villes as $ville){
            array_push($array, $ville['ville_nom']);
        }
        return json_encode($array);
    }
    
    public function pagination($table = '',$page,$par_page,$where = array()){
        echo "<ul class='pagination pagination-sm'>";
            $this->model->table = $table;
            $total_records = $this->model->count($where); 
            $total_pages = ceil($total_records / $par_page); 
            if($total_records <= $par_page){return '';}

            for ($i=1; $i<=$total_pages; $i++) { 
                echo "<li ";
                    if($page == $i){
                        echo "class='active'";
                    }
                echo ">";
                    echo "<a href='?page=".$i."'>".$i."</a>";
                echo "</li>";
            }   
       echo "</ul>";
    }

}