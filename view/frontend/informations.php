<?php session_start(); ?>
<?php refresh_session(); ?>

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

        <div id="message" class="row col-lg-offset-5 col-sm-6">
        <?= 'Erreur : ' . $e->getMessage(); ?>
        </div>

        <footer>
            <nav class="footer row">
                <div id="linkFooterAdmin" class="col-sm-2">
                    <a href="<?php if(isset($_SESSION['disconnect'])): ?>index.php?action=administration <?php else: ?>index.php?action=login<?php endif ?>" class="test" id="linkAdmin">
                    Administration
                    </a>
                </div>

                <?php if (isset($_SESSION['disconnect'])): ?>
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