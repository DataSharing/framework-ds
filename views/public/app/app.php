<div style="padding:3em;">
	<a href="deconnexion" class="btn btn-xs btn-warning">Deconnexion</a><br>
	<center><b><h2 class="alert alert-success">L'application est bien installée!</h2></b><br></Center>
	<i>- CSS BOOTSTRAP, JQUERY</i><br>
	<i>- Ajouter une page en ajoutant un controleur : ./controllers/Page.php</i><br>
	<i>-- Exemple de structure du controller (les deux premières fonction sont obligatoire):</i><br>
	<pre type="php">
	Class Page extends Controller{
		
		function __construct(){
			parent::__construct();
			$this->app_autoload();
		}
		
		function index($id = NULL){
			
		}
		
		function traitements($id){
			$submit = "";
			if(isset($_POST['submit'])) $submit = $_POST['submit'];
			
			if($submit == 'ajouter'){
			}elseif(submit == 'supprimer'){
			}
		}
		
		function FormPage(){
			$data['bonjour'] = "Bonjour";
			$this->view('page/formulaire',$data);
		}
		
		function FormPagePrivate(){
			$data['Admin'] = "Super Admin";
			$this->viewPrivate('admin/page',$data);
		}
	}
	</pre>
</div>
<div style="padding:3em;background:grey">
	<b>SECTION FOOTER</b><br>
	<i>- Modification dans le dossier : ./includes/footer.php</i>
</div>