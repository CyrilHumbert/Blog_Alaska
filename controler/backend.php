<?php

require_once('model/LoginManager.php');

use Blog_Alaska\model\LoginManager as LoginManager;

function verifLogin($postPseudo, $postPassword) {
    $loginManager = new LoginManager;

    $verifLogin = $loginManager->login();

    if($verifLogin['pseudo'] == $postPseudo && $verifLogin["passwordde"] == $postPassword) {
        session_start();
        $_SESSION['admin_id'] = $verifLogin['id'];
		$_SESSION['admin_pseudo'] = $verifLogin['pseudo'];
        $_SESSION['admin_mdp'] = $verifLogin['passwordde'];
        
        require('view/backend/pannelAdmin.php');
    }

    else {
        echo "2";
    }
}