<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Information - Alaska</title>
        <link href="public/css/bootstrap.min.css" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet"> 
        <script src="public/js/jquery-3.3.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>  
    </head>
        
    <body>
    
        <div class="container-fluid">
            <header id="headerBanInfos" class="row">
                <div class="btnRetourAccueil">
                    <a href="index.php" class="btn linkRetourAccueil">Retour à l'accueil</a>
                </div>

                <div class="container-fluid" id="firstLine">
                    <h1 id="titleInfos" class="text-center">Informations</h1>
                </div>
            </header>
        </div>  

        <div class="container informationsPage">

            <?php if(isset($informations)): ?>
                <div id="info" class="<?= $informations[0]; ?>">
                    <div class="help-block text-center">
                        <?= $informations[1] ?> : <?= $informations[2]; ?><br/>
                    </div>
                </div>
            <?php endif ?>

            <?php if(isset($e)): ?>
                <div id="messageInfo" class="text-center" style="color: red;">
                    <?= 'Erreur : ' . $e->getMessage(); ?>
                </div>
            <?php endif ?>

        </div>

        <footer class="footer container-fluid">
            <div id="linkFooterAdmin" class="col-xs-4 col-sm-2 col-lg-2">
                <a href="<?php if(isset($_SESSION['connected'])): ?>index.php?action=administration <?php else: ?>index.php?action=login<?php endif ?>" class="test" id="linkAdmin">
                    Administration
                </a>
            </div>

            <?php if (isset($_SESSION['connected'])): ?>
                <div id="linkFooterDisconnect" class="col-xs-offset-4 col-xs-2 col-sm-offset-8 col-md-offset-8 col-lg-offset-9 col-lg-1">
                    <a href="index.php?action=disconnect" id="linkDisconnect">
                        Déconnexion
                    </a>
                </div>
            <?php endif ?> 
        </footer>
    </body>
</html>