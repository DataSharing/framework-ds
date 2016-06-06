<?php
Class App extends Controller{
   
    /*
    public function includes_top(){
        include dirname(__FILE__)."/../core/db.php";
        include dirname(__FILE__).'/../core/model.php';
        include dirname(__FILE__).'/../includes/doctype.php'; 
    }
    
    public function includes_footer(){
        include dirname(__FILE__).'/../includes/footer.php'; 
    }
    */
    
    public function chargement_modals(){
        //Tous les modals
        $dossier = dirname(__FILE__)."/../views/modals";
        $fichiers = scandir($dossier);
        foreach($fichiers as $fichier){
            $ex = explode('.',$fichier);
            echo '<form name="'.$ex[1].'" action="" method="post">';
                $this->view("modals/".$fichier);
            echo "</form>";
        }
    }
        
    public function __run(){            
        //Menu principal
        echo '<section id="menu">';
            $this->view('menu');
            //include dirname(__FILE__).'/../elements/menu.php';
        echo '</section>';

        //Contenu central
        echo '<section id="tuiles">';
            $this->view('tuiles',$data);
            //include dirname(__FILE__).'/../elements/tuiles.php';
        echo '</section>';

        $this->chargement_modals($data);

        include dirname(__FILE__).'/../elements/volet.php';			
        echo '<div id="notif-block"></div>';
    }
}

