<?php $title = 'Connexion - Blog Alaska'; ?>

<?php ob_start(); ?>

<div class="container-fluid">
    <header id="headerBanLogin" class="row">
            <div class="btnRetourAccueil">
                <a href="index.php" class="btn linkRetourAccueil">Retour à l'accueil</a>
            </div>

            <div>
                    <h1 id="titleLogin" class="text-center">Connexion</h1>
            </div>
    </header>
</div>

<div class="container">
    <div id="formLogin" class="row col-sm-12 center-block">
        <form method="POST" action="index.php?action=login&amp;postLogin" class="form-inline">
            <div class="row">
                <div class="col-sm-6">
                    <label for="pseudo" class="labelPostAuthor">Pseudo</label>
                    <input id="pseudo" name="pseudo" type="text" class="inputPostAuthor"/>
                </div>

                <div class="col-sm-6 formPasswordLogin">
                    <label for="password" class="labelPostComment">Mot de passe</label>
                    <input id="password" name="password" type="password" class="inputPostComment"/>
                </div>
            </div>

            <?php if (isset($errorIdentifiant)): ?>
                <div class="row">
                    <div class="alert alert-block alert-danger text-center col-sm-offset-4 col-sm-4 box-error">
                    <h4>Erreur !</h4>
                    Identifiant incorrect ! 
                    </div>
                </div>
            <?php endif ?>  
            
            <?php if (isset($error403)): ?>
                <div class="row">
                    <div class="alert alert-block alert-danger text-center col-sm-offset-4 col-sm-4 box-error">
                    <h4>Erreur 403 !</h4>
                    Vous devez être connecté ! 
                    </div>
                </div>
            <?php endif ?>   

            <button name="button" class="btn linkLogin pull-right" type="submit" >Connexion</button>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

