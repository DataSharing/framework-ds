<?php

Class Plugin extends Controller {
   public function __construct() {
      $this->load('core/Model');
      $this->load('core/Formulaire', 'form');
      $this->load('core/Session');
   }
   public function _initPlugins() {
      $data['css'] = array();
      $data['js'] = array();
      $params = array();
      $plugins = $this->allPlugins();

      foreach ($plugins as $plugin) {
         if ($plugin['is_activated'] && $plugin['is_installed']) {
            include dirname(__FILE__) . '/../plugins/' . strtolower($plugin['name']) . '/setup.php';
            $app = New Setup();
            $params = $app->_init();
            if (isset($params[ucfirst($plugin['name'])]['css'])) {
               $allCss = $params[ucfirst($plugin['name'])]['css'];
               foreach ($allCss as $css) {
                  $data['css'][] = "plugins/" . strtolower($plugin['name']) . "/css/" . $css;
               }
            }

            if (isset($params[ucfirst($plugin['name'])]['js'])) {
               $allJs = $params["Example"]['js'];
               foreach ($allJs as $js) {
                  $data['js'][] = "plugins/" . strtolower($plugin['name']) . "/js/" . $js;
               }
            }
         }
      }
      return $data;
   }
   public function nb() {
      $dir = "./plugins";
      $plugins = scandir($dir);
      $informations = array();
      $count = 0;
      foreach ($plugins as $plugin) {
         if ($plugin == "." || $plugin == "..") {
            continue;
         }
         if ($this->isActivated($plugin) && $this->isInstalled($plugin)) {
            $count++;
         }
      }
      return $count;
   }
   public function isActivated($name) {
      $this->model->table = "plugins";
      $isActivated = $this->model->onerow('is_activated', array('nom' => $name));
      if ($isActivated == 1) {
         return true;
      }
      return false;
   }
   public function isInstalled($name) {
      $this->model->table = "plugins";
      $count = $this->model->count(array('nom' => $name));
      if ($count == 1) {
         return true;
      }
      return false;
   }
   public function install($name) {
      include dirname(__FILE__) . '/../plugins/' . strtolower($name) . '/setup.php';
      $plugin = New Setup();
      $tables = $plugin->_install();
      if ($this->installDb($tables)) {
         return true;
      }
      return false;
   }
   public function uninstall($name) {
      include dirname(__FILE__) . '/../plugins/' . strtolower($name) . '/setup.php';
      $plugin = New Setup();
      $tables = $plugin->_uninstall();
      if ($this->uninstallDb($tables)) {
         return true;
      }
      return false;
   }
   public function installDb($tables = array()) {
      foreach ($tables as $table) {
         if (!$this->model->createTable($table)) {
            return false;
         }
      }
      return true;
   }
   public function uninstallDb($tables = array()) {
      foreach ($tables as $table) {
         if (!$this->model->dropTable("DROP TABLE IF EXISTS " . $table)) {
            return false;
         }
      }
      return true;
   }
   public function allPlugins() {
      $dir = "./plugins";
      $plugins = scandir($dir);
      $informations = array();
      foreach ($plugins as $plugin) {
         if ($plugin == "." || $plugin == "..") {
            continue;
         }
         $informations[] = $this->dataPlugin($plugin);
      }
      return $informations;
   }
   public function dataPlugin($name) {
      include dirname(__FILE__) . '/../plugins/' . strtolower($name) . '/plugin.php';
      $plugin['is_activated'] = $this->isActivated($name);
      $plugin['is_installed'] = $this->isInstalled($name);
      return $plugin;
   }
   public function show() {

   }
}