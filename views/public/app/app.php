<div class="container" style="margin:4em auto;">
	<center><b><h3 class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> L'application est bien installée!</h3></b><br></center>
	<div class="col-md-7">
		<div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Controllers</h3>
	        </div>
	        <div class="panel-body">
	        	<i>- CSS BOOTSTRAP, JQUERY</i><br>
				<i>- Ajouter une page en ajoutant un controleur : ./controllers/Page.php</i><br>
				<i>-- Exemple de structure du controller (les deux premières fonction sont obligatoire):</i><br>
				<pre type="php">
Class Page extends Controller{

	public function __construct(){
		parent::__construct();
		$this->app_autoload();
	}
					
	public function index($id = NULL){
		$this->traitement($id);
		$this->FormPage();	
	}
		
	public function traitements($id){
		$submit = "";
		if(isset($_POST['submit'])) $submit = $_POST['submit'];
		
		if($submit == 'ajouter'){
		}elseif(submit == 'supprimer'){
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
	<div class="col-md-5">
		<!-- MENU -->
		<div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu</h3>
	        </div>
	        <div class="panel-body">
		        <i>- Modification du menu : <b>./views/public/menu/menu.php</b></i><br>
				<i>- Actions sur menu : <b>./core/Menu.php</b></i><br>
				<i>- Déclaration des fichiers css et js : <b>./config/styles.php</b></i>
	        </div>
	    </div>
	    <!-- FICHIER CONFIG -->
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Fichier autoload</h3>
	        </div>
	        <div class="panel-body">
		        <i>- Modification autoload : <b>./config/autoload.php</b></i><br>
				<i>- 3 arrays (models, controllers, core)</i><br>
				<i>- array('monmodel','aliasmonmodel')</i><br>
				<i>- Exemple utilisation:</i><br>
				<pre code="php">
$this->monmodel->mafunction();
//OU
$this->aliasmonmodel->mafunction();
				</pre>
	        </div>
	    </div>
	</div>
</div>
<nav class="navbar navbar-inverse navbar-fixed-bottom" style="color:white;padding:0.9em;height: 0.5em;text-align: center;">
	<p>By <b style="color:#f7464a;">Data</b>Sharing</p><br>
</nav>