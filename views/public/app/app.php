<div class="container" style="margin:3.6em auto;padding: 1em;">
	<center><b><h3 class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> L'application est bien installée!</h3></b><br></center>
	<div class="row">
	<div class="col-12 col-md-7">
		<div class="card ">
	        <div class="card-header">
	            <h3 class="card-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Controllers</h3>
	        </div>
	        <div class="card-block">
	        	<i>- CSS BOOTSTRAP 3, JQUERY</i><br>
				<i>- Ajouter une page en ajoutant un controleur : ./controllers/Page.php</i><br>
				<i>-- Exemple de structure du controller (les deux premières fonction sont obligatoire):</i><br>
				<pre type="php">
Class Page extends Controller{

	public function __construct(){
		parent::__construct();
		$this->load('core/Model');
		$this->load('core/Formulaire','form');
		$this->load('core/Session');
        $this->session->CheckRight('accueil',LECTURE);

	}
					
	public function index($id = NULL,$arg = NULL){
		$this->traitement($id);
		$this->FormPage();	
	}
		
	public function traitements($id, $arg){
		$submit = $_POST['submit'] ?? '';
    	$donnees = array('nom','prenom');

    	if($_POST){
	    	if($this->form->validate($donnees) == true){
	    		if($submit == "ajouter"){
	    			$this->session->CheckRight('accueil',MODIFICATION);
	    			var_dump($_POST);
	    		}
	    	}else{
	    		$this->view('app/erreurs/erreurs',$this->form->errors);
	    	}
	    }
	}
	
	public function FormPage(){
		$data['bonjour'] = "Bonjour";
		$this->view('page/formulaire',$data);
	}
	
	public function FormPagePrivate(){
		$data['Admin'] = "Super Admin";
		$this->viewPrivate('admin/page',$data);
	}
}
				</pre>
	        </div>
	    </div>
	</div>
	<div class="col-12 col-md-5">
		<!-- MENU -->
		<div class="card ">
	        <div class="card-header">
	            <h3 class="card-title"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu</h3>
	        </div>
	        <div class="card-block">
		        <i>- Modification du menu : <b>./views/public/menu/menu.php</b></i><br>
				<i>- Actions sur menu : <b>./core/Menu.php</b></i><br>
				<i>- Déclaration des fichiers css et js : <b>./config/styles.php</b></i>
	        </div>
	    </div><br/>
	    <!-- FICHIER FORM -->
	    <div class="card ">
	        <div class="card-header">
	            <h3 class="card-title"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Formulaire</h3>
	        </div>
	        <div class="card-block">
		        <form action="" method="post">
		        	<input type="text" name="nom" class="form-control" pattern="[a-zA-Z ]*" placeholder="Nom">
		        	<input type="text" name="prenom" class='form-control' pattern="[a-zA-Z ]*" placeholder="Prénom">
		        	<button type="submit" name="submit" value="ajouter" class="btn btn-success" >Ajouter</button>
		        </form>
	        </div>
	    </div>
	</div>
</div>
</div>
<nav class="navbar fixed-bottom navbar-dark bg-dark" >
	<p class="navbar-brand" style="text-align: center;width: 100%;">By <b style="color:#f7464a;">Data</b>Sharing</p><br>
</nav>