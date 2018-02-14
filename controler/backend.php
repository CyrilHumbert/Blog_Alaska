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

    $verifLogin = $loginManager->login();

    if($verifLogin['pseudo'] == $postPseudo && $verifLogin["passwordde"] == $postPassword) {
        session_start();
        $_SESSION['admin_id'] = $verifLogin['id'];
		$_SESSION['admin_pseudo'] = $verifLogin['pseudo'];
        $_SESSION['admin_mdp'] = $verifLogin['passwordde'];

        $_SESSION['connected'] = true;
        
        header('location: index.php?action=administration');
    }

    else{
        $error = true;

        require('view/frontend/loginAdminView.php');
    }
}

function pannelAdminView() {
    $listPosts = viewPostsAdmin();

    require('view/backend/pannelAdmin.php');
}

function viewEditor() {
    require('view/backend/editionAdmin.php');
}

function addPostAdmin($title, $content, $author) {
    $adminManager = new AdminManager;

    if(isset($title) && !empty($title) && isset($content) && !empty($content) && isset($author) && !empty($author)) {
        $adminManager->insertPostAdmin($title, $content, $author);

        header('location: index.php?action=administration');
    }

    else{
        $error = true;

        header('location: index.php?action=administration&editer');
    }
}

function refresh_session(){
    $adminManager = new AdminManager;

	if(isset($_SESSION['admin_id']) && intval($_SESSION['admin_id']) != 0) {     
        $infoSession = $adminManager->getInfoSession();
		
		if(isset($infoSession['pseudo']) && $infoSession['pseudo'] != '' && $_SESSION['admin_pseudo'] == $infoSession['pseudo']) {
            
            if($_SESSION['admin_mdp'] != $infoSession['passwordde']) {
				$informations = Array( /*Mot de passe de session incorrect*/
									true,
									'Session invalide',
									'Le mot de passe de votre session est incorrect, vous devez vous reconnecter.',
									'',
									'membres/connexion.php',
									3
									);
				require_once('../view/frontend/informations.php');
				$adminManager->empty_cookie();
				session_destroy();
				exit();
			}
			
			else {
					$_SESSION['admin_id'] = $infoSession['id'];
					$_SESSION['admin_pseudo'] = $infoSession['pseudo'];
                    $_SESSION['admin_mdp'] = $infoSession['passwordde'];
                    
                    $_SESSION['connected'] = true;
			}
		}
	}
	
	else {
		if(isset($_COOKIE['admin_id']) && isset($_COOKIE['admin_mdp'])) {
			if(intval($_COOKIE['admin_id']) != 0) {
				$infoSession = $adminManager->getInfoCookie();
				
				if(isset($infoSession['pseudo']) && $infoSession['pseudo'] != '' && $_COOKIE['admin_pseudo'] == $infoSession['pseudo']) {
					if($_COOKIE['membre_mdp'] != $infoSession['passwordde']) {
						$informations = Array( /*Mot de passe de cookie incorrect*/
											true,
											'Mot de passe cookie erroné',
											'Le mot de passe conservé sur votre cookie est incorrect vous devez vous reconnecter.',
											'',
											'membres/connexion.php',
											3
											);
                        require_once('../view/frontend/informations.php');
						$adminManager->empty_cookie();
						session_destroy();
						exit();
					}
					
					else {
						$_SESSION['admin_id'] = $infoSession['id'];
						$_SESSION['admin_pseudo'] = $infoSession['pseudo'];
                        $_SESSION['admin_mdp'] = $infoSession['passwordde'];
                        
                        $_SESSION['connected'] = true;
					}
				}
			}
			
			else {
				$informations = Array( /*L'id de cookie est incorrect*/
									true,
									'Cookie invalide',
									'Le cookie conservant votre id est corrompu, il va donc être détruit vous devez vous reconnecter.',
									'',
									'membres/connexion.php',
									3
									);
                require_once('../view/frontend/informations.php');
				$adminManager->empty_cookie();
				session_destroy();
				exit();
			}
		}
		
		else {
			if(isset($_SESSION['membre_id'])) unset($_SESSION['membre_id']);
			$adminManager->empty_cookie();
		}
	}
}

function disconnect() {
    session_start();
    session_unset();
    session_destroy();

    header('location: index.php');
}
