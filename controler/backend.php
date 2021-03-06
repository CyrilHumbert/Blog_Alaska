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

function viewConfig() {
	$adminManager = new AdminManager;

	$pseudoActually = $adminManager->getPseudoActually();

	$choiceModere = $adminManager->getChoiceModere();

	require('view/backend/configAdmin.php');
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

    if($verifLogin['pseudo'] == $postPseudo && password_verify($postPassword, $verifLogin["passwordde"])) {
        session_start();
        $_SESSION['admin_id'] = $verifLogin['id'];
		$_SESSION['admin_pseudo'] = $verifLogin['pseudo'];

        $_SESSION['connected'] = true;
        
		header('location: index.php?action=administration');
		exit();
    }

    else{
        $errorIdentifiant = true;

        require('view/frontend/loginAdminView.php');
    }
}

function refresh_session() {
    $loginManager = new LoginManager;

	if(isset($_SESSION['admin_id']) && intval($_SESSION['admin_id']) != 0) {     
        $infoSession = $loginManager->getInfoSession();
		
		if($_SESSION['admin_pseudo'] == $infoSession['pseudo']) {
            
            if($_SESSION['admin_id'] != $infoSession['id']) {
				$informations = Array( /*ID de session incorrect*/
									'has-error',
									'Session invalide',
									'Votre session est invalide, vous devez vous reconnecter.',
									'',
									'index.php',
									3
									);
				header("HTTP/1.0 403 Forbidden");
				require('view/frontend/informations.php');
				empty_cookie();
				session_unset();
				session_destroy();
				exit();
			}
			
			else {
					$_SESSION['admin_id'] = $infoSession['id'];
					$_SESSION['admin_pseudo'] = $infoSession['pseudo'];
                    
                    $_SESSION['connected'] = true;
			}
		}
		else {
			$informations = Array( /*Pseudo de session incorrect*/
								'has-error',
								'Session invalide',
								'Votre session est invalide, vous devez vous reconnecter.',
								'',
								'index.php',
								3
								);
			header("HTTP/1.0 403 Forbidden");
			require('view/frontend/informations.php');
			empty_cookie();
			session_unset();
			session_destroy();
			exit();
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

		require('view/backend/editionAdmin.php');
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

function chapterTrash($postId, $token) {
	$trashManager = new TrashManager;

	if ($_SESSION['token'] == $token) {
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
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}

function restoreTrash($idChapter, $token) {
	$trashManager = new TrashManager;

	if ($_SESSION['token'] == $token) {
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
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}

function deleteDefinitely($idChapterTrash, $idChapter, $token) {
	$trashManager = new TrashManager;

	if ($_SESSION['token'] == $token) {
		$trashManager->deleteDefinitelySinceTrash($idChapterTrash);
		$trashManager->deleteCommentFromTrashComments($idChapter);
		$trashManager->deleteDefinitelyIp($idChapter);

		header('location: index.php?action=administration&trash');
		exit();
	}
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
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

function modifPseudo($postPseudo, $token) {
	$adminManager = new AdminManager;

	if ($_SESSION['token'] == $token) {
		$postPseudo = trim($postPseudo);

		if(!empty($postPseudo)) {
			$adminManager->updatePseudo($postPseudo);

			$_SESSION['admin_pseudo'] = $postPseudo;

			header('location: index.php?action=administration&config');
			exit();
		}
		else {
			$modifPseudoEmpty = true;

			$pseudoActually = $adminManager->getPseudoActually();

			$choiceModere = $adminManager->getChoiceModere();

			require('view/backend/configAdmin.php');
		}
	}
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}

function modifPassword($postPasswordAncien, $postPasswordNew, $postPasswordConfirm, $token) {
	$adminManager = new AdminManager;

	if ($_SESSION['token'] == $token) {
		$confirmAncienPassword = $adminManager->confirmAncienPassword();

		if(password_verify($postPasswordAncien, $confirmAncienPassword["passwordde"])) {
			$postPasswordNew = trim($postPasswordNew);

			if(!empty($postPasswordNew)) {
				if($postPasswordNew == $postPasswordConfirm) {
					$hashPassword = password_hash($postPasswordNew, PASSWORD_DEFAULT);

					$adminManager->updatePassword($hashPassword);

					$validateChangePassword = true;

					$pseudoActually = $adminManager->getPseudoActually();

					$choiceModere = $adminManager->getChoiceModere();

					require('view/backend/configAdmin.php');
				}else {
					$badConfirmPassword = true;

					$pseudoActually = $adminManager->getPseudoActually();

					$choiceModere = $adminManager->getChoiceModere();

					require('view/backend/configAdmin.php');
				}
			}else {
				$newPasswordEmpty = true;

				$pseudoActually = $adminManager->getPseudoActually();

				$choiceModere = $adminManager->getChoiceModere();

				require('view/backend/configAdmin.php');
			}
		}else {
			$badAncienPassword = true;

			$pseudoActually = $adminManager->getPseudoActually();

			$choiceModere = $adminManager->getChoiceModere();

			require('view/backend/configAdmin.php');
		}
	}
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}

function modifModere($postModere1, $postModere2, $postModere3, $token) {
	$adminManager = new AdminManager;

	if ($_SESSION['token'] == $token) {
		$adminManager->updateChoiceModere($postModere1, $postModere2, $postModere3);

		header('location: index.php?action=administration&config');
		exit();
	}
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}

/**** GESTIONS DES COMMENTAIRES ****/

function modereComment($idComment, $choiceModere, $token) {
	$adminManager = new AdminManager;

	if ($_SESSION['token'] == $token) {
		$choiceDefModere = $adminManager->selectChoiceModere($choiceModere);

		$adminManager->modereAndUnsignalComment($choiceDefModere[0], $idComment);

		header('location: index.php?action=administration');
		exit();
	}
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}

function deleteSignalComment($idComment, $response, $idResponseComment, $comment_response, $token) {
	$adminManager = new AdminManager;

	if ($_SESSION['token'] == $token) {
		$adminManager->deleteSignalComment($idComment);

		if($comment_response == 1) {
			$checkResponse = $adminManager->checkResponseComment($idResponseComment);

			if($checkResponse) {
			}
			else {
				$adminManager->udpateHaveResponse(0, $idResponseComment);
			}
		}
		
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
	else {
			throw new Exception('Action impossible, cet accès est protégé.');
	}
}

function aproveSignal($idComment, $token) {
	$adminManager = new AdminManager;

	if ($_SESSION['token'] == $token) {
		$adminManager->unsignalComment($idComment);

		header('location: index.php?action=administration');
		exit();
	}
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}

function deleteCommentManual($idComment, $postId, $idResponseComment, $token) {
	$adminManager = new AdminManager;
	$trashManager = new TrashManager;

	if ($_SESSION['token'] == $token) {
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
	else {
			throw new Exception('Action impossible, cet accès est protégé.');
	}

}

function restoreCommentManual($idComment, $idResponseComment, $token) {
	$adminManager = new AdminManager;
	$trashManager = new TrashManager;

	if ($_SESSION['token'] == $token) {
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
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}

}

function deleteCommentFromTrash($idComment, $idResponseComment, $token) {
	$trashManager = new TrashManager;

	if ($_SESSION['token'] == $token) {
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
	else {
		throw new Exception('Action impossible, cet accès est protégé.');
	}
}