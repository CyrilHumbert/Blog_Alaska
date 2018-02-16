<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <link href="public/css/bootstrap.css" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet"> 
        <script src="public/js/jquery-3.3.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>  
    </head>
        
    <body>
    
        <div class="container-fluid">
            <header id="headerBan" class="row">
                <div class="row" id="firstLine">
                    <h1 id="titleAlaska" class="col-sm-offset-1 col-md-offset-2 col-lg-offset-2 col-lg-8">Billet simple pour l'Alaska</h1>
                </div>
                <div class="row" id="secondeLine">
                    <h1 id="titleJeanForteroche" class="col-lg-offset-6 col-sm-6 pull-right">De Jean Forteroche</h1>
                </div>
            </header>
        </div>  

        <div class="container">

            <?php if(isset($informations)): ?>
                <div id="info" class="<?= $informations[0]; ?>">
                    <div class="help-block text-center">
                        <?= $informations[1] ?> : <?= $informations[2]; ?><br/>
                        <a href="<?= $informations[4]; ?>">Cliquez ici pour revenir à l'accueil...</a>
                    </div>
                </div>
            <?php endif ?>

            <?php if(isset($e)): ?>
                <div id="messageInfo" class="text-center" style="color: red;">
                    <?= 'Erreur : ' . $e->getMessage(); ?>
                </div>
            <?php endif ?>

        </div>

        <footer>
            <nav class="footer row">
                <div id="linkFooterAdmin" class="col-sm-2">
                    <a href="<?php if(isset($_SESSION['connected'])): ?>index.php?action=administration <?php else: ?>index.php?action=login<?php endif ?>" class="test" id="linkAdmin">
                    Administration
                    </a>
                </div>

                <?php if (isset($_SESSION['connected'])): ?>
                    <div id="linkFooterDisconnect" class="col-sm-1 pull-right">
                        <a href="" id="linkDisconnect">
                            Déconnexion
                        </a>
                    </div>
                <?php endif ?> 
            </nav>
        </footer>

        <script>
            $(window).resize(function() {
            $('h1').css('z-index', 'auto'); //auto reflow
            });
        </script>
    </body>
</html>