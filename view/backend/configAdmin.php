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

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>