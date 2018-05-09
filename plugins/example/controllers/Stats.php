<?php

Class Stats extends Plugin{
	public function indexForm(){
		$this->traitementForm();
		$data['links'] = array('link','link_1','linl_2','link_3');
		$this->viewPlugin("Example","example",$data);
	}

	public function traitementForm(){
		if(isset($_POST['go'])){
			$this->view('app/succes/notification','Mise à jour : OK!'.var_dump($_POST));
		}
	}
}