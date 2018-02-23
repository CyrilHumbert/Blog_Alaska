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

function viewCommentsTrash() {
	$trashManager = new TrashManager;

	$listCommentsTrash = $trashManager->listCommentsTrash();

	return $listCommentsTrash;
}

function viewSignalComment() {
	$adminManager = new AdminManager;

	$listSignalComments = $adminManager->getCommentSignal();

	return $listSignalComments;
}

function viewTrash() {
	$listPostsTrash = viewPostsTrash();

	$listCommentsTrash = viewCommentsTrash();

	require('view/backend/trashAdmin.php');
}

function pannelAdminView() {
	$listPosts = viewPostsAdmin();
	
	$listSignalComments = viewSignalComment();

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
		exit();
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
									'has-error',
									'Session invalide',
									'Le mot de passe de votre session est incorrect, vous devez vous reconnecter.',
									'',
									'index.php',
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
											'has-error',
											'Mot de passe cookie erroné',
											'Le mot de passe conservé sur votre cookie est incorrect vous devez vous reconnecter.',
											'',
											'index.php',
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
									'has-error',
									'Cookie invalide',
									'Le cookie conservant votre id est corrompu, il va donc être détruit vous devez vous reconnecter.',
									'',
									'index.php',
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
	exit();
}

/**** GESTION DES CHAPITRES ****/

function addPostAdmin($title, $content, $author, $status) {
    $adminManager = new AdminManager;

    if(isset($title) && !empty($title) && isset($content) && !empty($content) && isset($author) && !empty($author)) {
        $adminManager->insertPostAdmin($title, $content, $author, $status);

		header('location: index.php?action=administration');
		exit();
    }

    else{
        $error = true;

		header('location: index.php?action=administration&editer');
		exit();
    }
}

function editerModif($postId) {
	$adminManager = new AdminManager;

	$data = $adminManager->getChapterModif($postId);

	$modified = true;

	require('view/backend/editionAdmin.php');
}

function chapterModif($postTitle, $postAuthor, $postContent, $status, $getId) {
	$adminManager = new AdminManager;

	$modifChapter = $adminManager->updateChapter($postTitle, $postAuthor, $postContent, $status, $getId);

	if($modifChapter == false)
	{
		throw new Exception('Identifiant de chapitre incorrect');
	}
	else
	{
		header('location: index.php?action=administration');
		exit();
	}
}

function chapterTrash($postId) {
	$trashManager = new TrashManager;

	$chapterSelected = $trashManager->selectChapterFromPosts($postId);
	$commentSelectedData = $trashManager->selectCommentFromComments($postId);

	$trashManager->insertChapterInTrash($chapterSelected['id'], $chapterSelected['title'], $chapterSelected['nb_views'], $chapterSelected['author'], $chapterSelected['content'], $chapterSelected['creation_date'], $chapterSelected['status_post']);
	foreach($commentSelectedData as $row => $commentSelected) 
	{
		$trashManager->insertCommentInTrashComment($commentSelected['id'], $commentSelected['post_id'], $commentSelected['author'], $commentSelected['comment'], $commentSelected['comment_date'], $commentSelected['comment_signal'], $commentSelected['have_response'], $commentSelected['comment_response'], $commentSelected['id_comment'], $commentSelected['delete_manual'], $commentSelected['comment_principal_delete']);
	}

	$verifChapter = $trashManager->verifChapterSinceTrash($postId);
	if($commentSelectedData){
		$verifComment = $trashManager->verifCommentSinceTrashComments($postId);
	}

	if($verifChapter) {
			$trashManager->deleteChapterFromPosts($postId);
			if(isset($verifComment)){
				$trashManager->deleteCommentFromComments($postId);
			}

			$trashManager->updateDeleteManual($postId);

			$trashManager->updateCommentPrincipalDeleteByDeleteChapter($postId);

			header('location: index.php?action=administration');
			exit();
	}
	else {
		throw new Exception('Il a y eu une erreur lors de la suppression du chapitre.');
	}
}

function restoreTrash($idChapter) {
	$trashManager = new TrashManager;

	$chapterSelected = $trashManager->selectChapterFromTrash($idChapter);
	$commentSelectedData = $trashManager->selectCommentFromTrashComments($idChapter);

	$trashManager->insertChapterInPosts($chapterSelected['id_chapter'], $chapterSelected['title'], $chapterSelected['nb_views'], $chapterSelected['author'], $chapterSelected['content'], $chapterSelected['creation_date'], $chapterSelected['status_post']);
	foreach($commentSelectedData as $row => $commentSelected) 
	{
		$trashManager->insertCommentInComments($commentSelected['id_before_delete'], $commentSelected['post_id'], $commentSelected['author'], $commentSelected['comment'], $commentSelected['comment_date'], $commentSelected['comment_signal'], $commentSelected['have_response'], $commentSelected['comment_response'], $commentSelected['id_comment'], $commentSelected['delete_manual'], $commentSelected['comment_principal_delete']);
	}

	$verifChapter = $trashManager->verifChapterSincePosts($idChapter);
	if($commentSelectedData) {
		$verifComment = $trashManager->verifCommentSinceComments($idChapter);
	}

	if($verifChapter) {
			$trashManager->deleteChapterFromTrash($idChapter);
			if(isset($verifComment)){
				$trashManager->deleteCommentFromTrashComments($idChapter);
			}

			header('location: index.php?action=administration&trash');
			exit();
	}
	else {
		throw new Exception('Il a y eu une erreur lors de la restauration du chapitre.');
	}
}

function deleteDefinitely($idChapterTrash, $idChapter) {
	$trashManager = new TrashManager;

	$trashManager->deleteDefinitelySinceTrash($idChapterTrash);
	$trashManager->deleteCommentFromTrashComments($idChapter);
	$trashManager->deleteDefinitelyIp($idChapter);

	header('location: index.php?action=administration&trash');
	exit();
}

/**** FONCTION UTILITAIRES ****/

function checkVisite($ip, $idChapter) {
	$adminManager = new AdminManager;

	$checkIp = $adminManager->getCheckIp($ip, $idChapter);

	if($checkIp == false) {
		$adminManager->insertIp($ip, $idChapter);

		$adminManager->incrementView($idChapter);
	}
}

/**** GESTIONS DES COMMENTAIRES ****/

function modereComment($idComment) {
	$adminManager = new AdminManager;

	$adminManager->modereAndUnsignalComment($idComment);

	header('location: index.php?action=administration');
	exit();
}

function deleteSignalComment($idComment, $response) {
	$adminManager = new AdminManager;

	$adminManager->deleteSignalComment($idComment);

	if ($response == 1) {
		$adminManager->deleteResponseLinkAsSignal($idComment);

		header('location: index.php?action=administration');
		exit();
	}
	else {
		header('location: index.php?action=administration');
		exit();
	}
}

function aproveSignal($idComment) {
	$adminManager = new AdminManager;

	$adminManager->unsignalComment($idComment);

	header('location: index.php?action=administration');
	exit();
}

function deleteCommentManual($idComment, $postId, $idResponseComment) {
	$adminManager = new AdminManager;
	$trashManager = new TrashManager;

	$commentSelected = $adminManager->selectCommentForManualDelete($idComment);
	if($commentSelected['have_response'] == 1) {
		$commentSelectedResponse = $adminManager->selectCommentResponseManualDelete($idComment);
	}

	$trashManager->insertCommentInTrashComment($commentSelected['id'], $commentSelected['post_id'], $commentSelected['author'], $commentSelected['comment'], $commentSelected['comment_date'], $commentSelected['comment_signal'], $commentSelected['have_response'], $commentSelected['comment_response'], $commentSelected['id_comment'], 1, $commentSelected['comment_principal_delete']);
	if($commentSelectedResponse) {
		foreach($commentSelectedResponse as $row => $commentSelectedResponseData) 
		{
			$trashManager->insertCommentInTrashComment($commentSelectedResponseData['id'], $commentSelectedResponseData['post_id'], $commentSelectedResponseData['author'], $commentSelectedResponseData['comment'], $commentSelectedResponseData['comment_date'], $commentSelectedResponseData['comment_signal'], $commentSelectedResponseData['have_response'], $commentSelectedResponseData['comment_response'], $commentSelectedResponseData['id_comment'], 1, $commentSelectedResponseData['comment_principal_delete']);
		}
	}

	$verifComment = $adminManager->verifCommentForManualDelete($idComment);

	if($verifComment) {
		$adminManager->deleteCommentForManualDelete($idComment);
		if($commentSelectedResponse) {
			foreach($commentSelectedResponse as $row => $commentSelectedResponseData) 
			{
				$adminManager->deleteCommentForManualDelete($commentSelectedResponseData['id']);
			}
		}

		if($commentSelected['comment_response'] == 0) 
		{
			$adminManager->updateCommentPrincipalDelete($idComment);
		}

		if($commentSelected['comment_response'] == 1) {
			if($idResponseComment > 0) {
				$testComment = $adminManager->selectCommentResponseManualDelete($idResponseComment);

				if($testComment)
				{
					header('Location: index.php?action=chapter&id=' . $postId);
					exit();
				}
				else 
				{
					$adminManager->udpateHaveResponse(0, $idResponseComment);

					header('Location: index.php?action=chapter&id=' . $postId);
					exit();
				}
			}
		}

		header('Location: index.php?action=chapter&id=' . $postId);
		exit();
	}

}

function restoreCommentManual($idComment, $idResponseComment) {
	$adminManager = new AdminManager;
	$trashManager = new TrashManager;

	$commentSelected = $adminManager->selectCommentFromTrashCommentsManualDelete($idComment);
	if($commentSelected['have_response'] == 1)
	{
		$commentSelectedResponse = $adminManager->selectCommentResponseManualDeleteFromTrash($idComment);
	}

	$trashManager->insertCommentInComments($commentSelected['id_before_delete'], $commentSelected['post_id'], $commentSelected['author'], $commentSelected['comment'], $commentSelected['comment_date'], $commentSelected['comment_signal'], $commentSelected['have_response'], $commentSelected['comment_response'], $commentSelected['id_comment'], 0, $commentSelected['comment_principal_delete']);
	if($commentSelectedResponse) {
		foreach($commentSelectedResponse as $row => $commentSelectedResponseData) 
		{
			$trashManager->insertCommentInComments($commentSelectedResponseData['id_before_delete'], $commentSelectedResponseData['post_id'], $commentSelectedResponseData['author'], $commentSelectedResponseData['comment'], $commentSelectedResponseData['comment_date'], $commentSelectedResponseData['comment_signal'], $commentSelectedResponseData['have_response'], $commentSelectedResponseData['comment_response'], $commentSelectedResponseData['id_comment'], 0, $commentSelectedResponseData['comment_principal_delete']);
		}
	}

	$verifComment = $adminManager->verifCommentForManualDeleteFromComments($idComment);

	if($verifComment) {
		$adminManager->deleteCommentForManualDeleteFromTrash($idComment);
		if($commentSelectedResponse) {
			foreach($commentSelectedResponse as $row => $commentSelectedResponseData) 
			{
				$adminManager->deleteCommentForManualDeleteFromTrash($commentSelectedResponseData['id_before_delete']);
			}
		}

		if($commentSelected['comment_response'] == 0) 
		{
			$adminManager->updateCommentPrincipalDeleteForRestor($idComment);
		}

		if($commentSelected['comment_response'] == 1) {
			if($idResponseComment > 0) {
				$adminManager->udpateHaveResponse(1, $idResponseComment);

				header('location: index.php?action=administration&trash');
				exit();
			}
		}

		header('location: index.php?action=administration&trash');
		exit();
	}

}

function deleteCommentFromTrash($idComment, $idResponseComment) {
	$trashManager = new TrashManager;

	$trashManager->deleteDefinitelyCommentManualFromTrash($idComment);
	$trashManager->deleteDefinitelyCommentResponseManualFromTrash($idComment);

	if($idResponseComment > 0)
	{
		$verifCommentResponse = $trashManager->getCommentResponseFromTrash($idResponseComment);

		if($verifCommentResponse)
		{
			header('location: index.php?action=administration&trash');
			exit();
		}
		else
		{
			$trashManager->updateHaveResponseFromTrash($idResponseComment);

			header('location: index.php?action=administration&trash');
			exit();
		}
	}

	header('location: index.php?action=administration&trash');
	exit();
}