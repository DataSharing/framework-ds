<?php

Class Cron extends Controller{
   
    Public function __construct(){
        parent::__construct();
        include(dirname(__FILE__).'/../locales/'.$this->langage.'/logs.php');
    }

}
