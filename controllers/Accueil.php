<?php
/**
 * Page Accueil
 * vue : views/Public/app/app.php
 *  * @author Walid Heddaji
 */
Class Accueil extends Controller{

    function index($id = ""){
        $this->view('app/app');
    }
}

