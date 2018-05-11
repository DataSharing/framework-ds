<?php 
/**
 * Page Plugins
 * vue : views/Public/plugins
 *  * @author Walid H.
 */

Class Plugins extends Controller{
	public function __construct(){
		parent::__construct();
		$this->load('core/Model');
		$this->load('core/Formulaire','form');
		$this->load('core/Session');	
		$this->load('core/Plugin');	
	}

	public function index($id = NULL,$arg = NULL){
		$this->traitement($id,$arg);
		if($id != null){
			$this->session->CheckRight('plugin_'.strtolower($id),LECTURE);
			$this->pluginForm($id,$arg);
		}else{
			$this->session->CheckRight('plugins',LECTURE);
			$this->indexForm();
		}
	}

	public function traitement($id,$arg){
		$post = $this->form->ProtectionFormulaire($_POST);

		if ($_POST) {
			$this->session->CheckRight('plugins',MODIFICATION);
			if(isset($_POST["activer"])){
				$this->model->table = "plugins";
				$count = $this->model->count(array('nom'=>$_POST['activer']));
				if($count == 1){
					if($this->model->maj(array('nom'=>$_POST['activer']),array('is_activated'=>1))){
						$this->view('app/succes/notification','Le plugin a bien été activé');
					}else{
						$this->view('app/erreurs/erreur','Erreur lors de l\'activation du plugin');
					}
				}else{
					$this->view('app/warning/index','Le plugin n\'est pas installé');
				}
			}

			if(isset($_POST["desactiver"])){
				$this->model->table = "plugins";
				$count = $this->model->count(array('nom'=>$_POST['desactiver']));
				if($this->model->maj(array('nom'=>$_POST['desactiver']),array('is_activated'=>0))){
					$this->view('app/succes/notification','Le plugin a bien été désactivé');
				}else{
					$this->view('app/erreurs/erreur','Erreur lors de la désactivation du plugin');
				}
			}

			if(isset($_POST["installer"])){
				$this->model->table = "plugins";
				if($this->model->insertion(array('nom'=>$_POST['installer']))){
					if($this->plugin->install($_POST['installer'])){
						$this->view('app/succes/notification','Le plugin a bien été installé');
					}else{
						$this->view('app/erreurs/erreur','Erreur d\'installation, vérifier le fichier setup.php de votre plugin');
					}
				}else{
					$this->view('app/erreurs/erreur','Erreur lors de l\'installation du plugin');
				}
			}

			if(isset($_POST["desinstaller"])){
				$this->model->table = "plugins";
				if($this->model->delete(array('nom'=>$_POST['desinstaller']))){
					$this->view('app/succes/notification','Le plugin a bien été désinstallé');
				}else{
					$this->view('app/erreurs/erreur','Erreur lors de la désinstallation du plugin');
				}
			}
		}
	}

	public function indexForm(){
		$data['plugins'] = $this->plugin->allPlugins();
		$this->view('plugins/index',$data);
	}

	public function pluginForm($plugin,$ctrl){
		$ex = explode('&',$ctrl);
		$ctrl = $ex[0];
		if($ctrl == '404'){
			$this->view('app/erreurs/404');
		}else{
			if($ctrl == null){
				$controller = dirname(__FILE__)."/../plugins/".$plugin."/controllers/".ucfirst($plugin).".php";
				if(file_exists($controller)){
					include $controller;
					$instancePlugin = New $plugin();
					$instancePlugin->indexForm();
				}else{
					$this->redirect('plugins/'.$plugin.'/404');
				}
			}else{
				if($ctrl == "index"){
					$ctrl = $plugin;
				}
				$controller = "./plugins/".$plugin."/controllers/".ucfirst($ctrl).".php";
				if(file_exists($controller)){
					include $controller;
					$instancePlugin = New $ctrl();
					$instancePlugin->indexForm();
				}else{
					$this->redirect('plugins/'.$plugin.'/404');
				}
			}
		}
	}
}