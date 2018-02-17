<?php

require_once('model/LoginManager.php');
require_once('model/AdminManager.php');
require_once('model/TrashManager.php');

use Blog_Alaska\model\LoginManager as LoginManager;
use Blog_Alaska\model\AdminManager as AdminManager;
use Blog_Alaska\model\TrashManager as TrashManager;

/**** VIEW ****/

function viewEditer() {
    require('view/backend/editionAdmin.php');
}

function viewPostsAdmin() {
    $adminManager = new AdminManager;

    $listPosts = $adminManager->listPostsAdmin();

    return $listPosts;
}

function viewPostsTrash() {
    $trashManager = new TrashManager;

    $listPosts = $trashManager->listPostsTrash();

    return $listPosts;
}

function viewTrash() {
	$listPosts = viewPostsTrash();

	require('view/backend/trashAdmin.php');
}

function pannelAdminView() {
    $listPosts = viewPostsAdmin();

    require('view/backend/pannelAdmin.php');
}

/**** GESTION DES ERREURS ****/

function accessDenied() {
	header("HTTP/1.0 403 Forbidden");

	$error403 = true;

	require('view/frontend/loginAdminView.php');
}

/**** GESTION DE SESSION ****/

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
        $errorIdentifiant = true;

        require('view/frontend/loginAdminView.php');
    }
}

function empty_cookie(){
    foreach($_COOKIE as $key => $element){
            setcookie($key, '', time()-3600);
        }
}

function refresh_session(){
    $loginManager = new LoginManager;

	if(isset($_SESSION['admin_id']) && intval($_SESSION['admin_id']) != 0) {     
        $infoSession = $loginManager->getInfoSession();
		
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
				empty_cookie();
				session_unset();
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
				$infoSession = $loginManager->getInfoCookie();
				
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
						empty_cookie();
						session_unset();
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
				empty_cookie();
				session_unset();
				session_destroy();
				exit();
			}
		}
		
		else {
			if(isset($_SESSION['membre_id'])) unset($_SESSION['membre_id']);
			empty_cookie();
		}
	}
}

function disconnect() {
    session_start();
    session_unset();
    session_destroy();

    header('location: index.php');
}

/**** GESTION DES CHAPITRES ****/

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

function editerModif($postId) {
	$adminManager = new AdminManager;

	$data = $adminManager->getChapterModif($postId);

	$modified = true;

	require('view/backend/editionAdmin.php');
}

function chapterModif($postTitle, $postAuthor, $postContent, $getId) {
	$adminManager = new AdminManager;

	$adminManager->updateChapter($postTitle, $postAuthor, $postContent, $getId);

	header('location: index.php?action=administration');
}

function chapterTrash($postId) {
	$trashManager = new TrashManager;

	$chapterSelected = $trashManager->selectChapterFromPosts($postId);

	$trashManager->insertChapterInTrash($chapterSelected['id'], $chapterSelected['title'], $chapterSelected['author'], $chapterSelected['content'], $chapterSelected['creation_date']);

	$verifChapter = $trashManager->verifChapterSinceTrash($postId);

	if(isset($verifChapter) && !empty($verifChapter)) {
		$trashManager->deleteChapterFromPosts($postId);

		header('location: index.php?action=administration');
	}
}

function restoreTrash($idChapter) {
	$trashManager = new TrashManager;

	$chapterSelected = $trashManager->selectChapterFromTrash($idChapter);

	$trashManager->insertChapterInPosts($chapterSelected['id_chapter'], $chapterSelected['title'], $chapterSelected['author'], $chapterSelected['content'], $chapterSelected['creation_date']);

	$verifChapter = $trashManager->verifChapterSincePosts($idChapter);

	if(isset($verifChapter) && !empty($verifChapter)) {
		$trashManager->deleteChapterFromTrash($idChapter);

		header('location: index.php?action=administration&trash');
	}
}

function deleteDefinitely($idChapterTrash) {
	$trashManager = new TrashManager;

	$trashManager->deleteDefinitelySinceTrash($idChapterTrash);

	header('location: index.php?action=administration&trash');
}