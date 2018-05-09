<?php

Class Setup extends Plugin{
	public function _init(){
		//$_PLUGIN['Example']['css'] = array("style.css",'custom.css');
		$params['Example']['js'] = array("app.js");
		return $params;
	}
	public function _install(){
		$tables[] = "CREATE TABLE IF NOT EXISTS plugins_example_test (
			id INT(11) NOT NULL AUTO_INCREMENT,
			nom VARCHAR(255) NOT NULL,
			is_activated INT(1) NOT NULL DEFAULT 0,
			PRIMARY KEY (id)) ENGINE=MyISAM";
		$tables[] = "CREATE TABLE IF NOT EXISTS plugins_example_test1 (
			id INT(11) NOT NULL AUTO_INCREMENT,
			nom VARCHAR(255) NOT NULL,
			is_activated INT(1) NOT NULL DEFAULT 0,
			PRIMARY KEY (id)) ENGINE=MyISAM";
		return $tables;
	}

	public function _uninstall(){
		$tables = array('plugins_example_test','plugins_example_test1');
		return $tables;
	}
}