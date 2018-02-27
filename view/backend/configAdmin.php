<?php $title = "Configuration - Administration"; ?>

<?php ob_start(); ?>

<div class="container-fluid">
    <header id="headerBanConfig" class="row">
        <div class="btnRetourPannel">
            <a href="index.php?action=administration" class="btn linkRetourPannel">Retour à l'administration</a>
        </div>

        <div class="row">
            <h1 id="titleConfig" class="text-center">Configuration</h1>
        </div>
    </header>
</div>  

<div class="container">
    <div id="modifPseudo" class="thumbnail">
        <h3 class="text-center titleModifPseudo">Modification du pseudo</h3>

        <p class="text-center" style="font-size: 1.2em;"><strong>Pseudo actuel</strong> : <?= $pseudoActually['pseudo']; ?></p>
        <form method="POST" action="index.php?action=administration&amp;config&amp;modifpseudo" class="form-inline">
            <div class="text-center">
                <label for="pseudoModif" class="labelModifPseudo">Nouveau pseudo</label><br>
                <input type="text" name="pseudoModif" class="form-control"/>
            </div>

            <button type="submit" class="btn btnModifPseudo center-block">Valider</button>
        </form>

        <?php if(isset($modifPseudoEmpty)): ?>
        <div class="container">
            <div class="alert alert-block alert-danger text-center col-sm-offset-4 col-sm-4 box-error">
                <h4>Erreur !</h4>
                Le champs du nouveau pseudo ne doit pas être vide !
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div id="modifPassword" class="thumbnail">
        <h3 class="text-center titleModifPseudo">Modification du mot de passe</h3>

        <form method="POST" action="index.php?action=administration&amp;config&amp;changepassword" class="form-inline formPasswordChange">
            <div class="text-center">
                <label for="ancienPassword">Ancien mot de passe</label><br>
                <input type="password" name="ancienPassword" class="form-control" />
            </div>

            <div class="text-center">
                <label for="newPassword">Nouveau mot de passe</label><br>
                <input type="password" name="newPassword" class="form-control" />
            </div>

            <div class="text-center">
                <label for="confirmPassword">Confirmation mot de passe</label><br>
                <input type="password" name="confirmPassword" class="form-control" />
            </div>

            <button type="submit" class="btn btnModifPassword center-block">Valider</button>
        </form>

        <?php if(isset($newPasswordEmpty)): ?>
        <div class="container">
            <div class="alert alert-block alert-danger text-center col-sm-offset-4 col-sm-4 box-error">
                <h4>Erreur !</h4>
                Le champs nouveau mot de passe ne peut pas être vide !
            </div>
        </div>
        <?php endif; ?>

        <?php if(isset($badAncienPassword)): ?>
        <div class="container">
            <div class="alert alert-block alert-danger text-center col-sm-offset-4 col-sm-4 box-error">
                <h4>Erreur !</h4>
                L'ancien mot de passe est incorrect !
            </div>
        </div>
        <?php endif; ?>

        <?php if(isset($badConfirmPassword)): ?>
        <div class="container">
            <div class="alert alert-block alert-danger text-center col-sm-offset-4 col-sm-4 box-error">
                <h4>Erreur !</h4>
                Les mots de passe ne sont pas identique !
            </div>
        </div>
        <?php endif; ?>

        <?php if(isset($validateChangePassword)): ?>
        <div class="container">
            <div class="alert alert-block alert-success text-center col-sm-offset-4 col-sm-4 box-error">
                <h4>Validé !</h4>
                Le mot de passe a été changer avec succès !
            </div>
        </div> 
        <?php endif; ?>
    </div>

    <div id="modifModere" class="thumbnail row text-center center-block" style="width: 100%;">
        <h3 class="titleModifPseudo">Modification des choix de modération</h3>

        <form method="POST" action="index.php?action=administration&amp;config&amp;modifmodere">
            <div class="col-sm-4">
                <label for="choiceModere1">Choix n°1</label><br>
                <textarea name="choiceModere1"><?= $choiceModere['modere1'] ?></textarea>
            </div>

            <div class="col-sm-4">
                <label for="choiceModere2">Choix n°2</label><br>
                <textarea name="choiceModere2"><?= $choiceModere['modere2'] ?></textarea>
            </div>

            <div class="col-sm-4">
                <label for="choiceModere3">Choix n°3</label><br>
                <textarea name="choiceModere3"><?= $choiceModere['modere3'] ?></textarea>
            </div>

            <button type="submit" class="btn btnModifModere center-block">Valider</button>
        </form>
    </div>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>