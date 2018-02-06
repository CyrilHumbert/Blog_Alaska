<?php $title = 'Connexion'; ?>

<?php ob_start(); ?>

<div class="container-fluid">

    <div class="row">
        <p class="col-sm-offset-1 col-sm-11"><a href="index.php">Retour à l'accueil</a></p>
    </div>

    <div class="row">
        <h2 class="text-center">Connexion au service d'administration</h2>
    </div>

    <div id="formLogin" class="row text-center">
        <form method="POST" >
            <div class="form-group">
                <label for="pseudo">Identifiant :</label>
                <input id="pseudo" name="pseudo" type="text"/>
            </div>

            <div class="form-group formPassword">
                <label for="password">Mot de passe :</label>
                <input id="password" name="password" type="password" />
            </div>

            <input type="submit" name="button" value="Connexion" />
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

