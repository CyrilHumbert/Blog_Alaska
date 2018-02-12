<?php

require_once('model/LoginManager.php');
require_once('model/AdminManager.php');

use Blog_Alaska\model\LoginManager as LoginManager;
use Blog_Alaska\model\AdminManager as AdminManager;

function viewPostsAdmin() {
    $adminManager = new AdminManager;

    $listPosts = $adminManager->listPostsAdmin();

    return $listPosts;
}

function verifLogin($postPseudo, $postPassword) {
    $loginManager = new LoginManager;
    $adminManager = new AdminManager;

    $verifLogin = $loginManager->login();

    if($verifLogin['pseudo'] == $postPseudo && $verifLogin["passwordde"] == $postPassword) {
        session_start();
        $_SESSION['admin_id'] = $verifLogin['id'];
		$_SESSION['admin_pseudo'] = $verifLogin['pseudo'];
        $_SESSION['admin_mdp'] = $verifLogin['passwordde'];

        $listPosts = $adminManager->listPostsAdmin();
        
        require('view/backend/pannelAdmin.php');
    }

    else{
        $error = true;

        require('view/frontend/loginAdminView.php');
    }
}

function viewEditor() {
    require('view/backend/editionAdmin.php');
}

function addPostAdmin($title, $content) {
    $adminManager = new AdminManager;

    if(isset($title) && !empty($title) && isset($content) && !empty($content)) {
        $adminManager->insertPostAdmin($title, $content);

        $listPosts = $adminManager->listPostsAdmin();

        require('view/backend/pannelAdmin.php');
    }

    else {
        $error = true;

        require('view/backend/editionAdmin.php');
    }
}