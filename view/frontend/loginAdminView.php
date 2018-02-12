<?php $title = 'Connexion'; ?>

<?php ob_start(); ?>

<div class="container-fluid">

    <div class="row">
        <p class="col-sm-offset-1 col-sm-11"><a href="index.php">Retour à l'accueil</a></p>
    </div>

    <div class="row">
        <h2 class="text-center">Connexion au service d'administration</h2>
    </div>

    <div id="formLogin" class="row col-sm-12 center-block">
        <form method="POST" action="index.php?action=login&amp;postLogin" class="well">
            <div class="form-group form-inline col-sm-7 col-sm-offset-5 ">
                <label for="pseudo">Identifiant :</label>
                <input id="pseudo" name="pseudo" type="text" class="form-control"/>
            </div>

            <div class="form-group form-inline formPassword col-sm-7">
                <label for="password">Mot de passe :</label>
                <input id="password" name="password" type="password" class="form-control"/>
            </div>

            <?php if (isset($error)): ?>
            <div class="row">
                <div class="alert alert-block alert-danger text-center col-sm-12">
                <h4>Erreur !</h4>
                Identifiant incorrect ! 
                </div>
            </div>
            <?php endif ?>   

            <button name="button" class="btn btn-primary col-sm-offset-6" >Connexion</button>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

