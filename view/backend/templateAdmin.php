<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <link rel="icon" href="public/images/favicon1.gif" type="image/gif">
        <link href="public/css/bootstrap.css" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
        <script src="public/js/jquery-3.3.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>   
    </head>
        
    <body>

        <?= $content; ?>

        <footer class="footer container-fluid">
            <div id="linkFooterAdmin" class="col-xs-4 col-sm-2 col-lg-2">
                <a href="<?php if(isset($_SESSION['connected'])): ?>index.php?action=administration <?php else: ?>index.php?action=login<?php endif ?>" class="test" id="linkAdmin">
                    Administration
                </a>
            </div>

            <?php if (isset($_SESSION['connected'])): ?>
                <div id="linkConfigAdmin" class="col-xs-1 col-xs-offset-1 col-sm-offset-4 col-sm-1 col-lg-offset-4 col-lg-1">
                    <a href="index.php?action=administration&amp;config"><span class="glyphicon glyphicon-cog iconConfig"></span></a>
                </div>
            <?php endif ?> 

            <?php if (isset($_SESSION['connected'])): ?>
                <div id="linkFooterDisconnectAdmin" class="col-xs-offset-2 col-xs-2 col-sm-offset-3 col-md-offset-3 col-lg-offset-4 col-lg-1">
                    <a href="index.php?action=disconnect" id="linkDisconnect">
                        Déconnexion
                    </a>
                </div>
            <?php endif ?> 
        </footer>
        
        <script>
            $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
            });
        </script>
    </body>
</html>