<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/bootstrap.css" rel="stylesheet"> 
        <link href="public/css/style.css" rel="stylesheet">   
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

        <?= $content ?>

        <footer>
            <nav class="navbar navbar-default navbar-fixed-bottom">
                <a href="#" class="container test col-lg-12" id="linkAdmin">
                Administration
                </a>
            </nav>
        </footer>

        <script src="public/js/jquery-3.3.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>
        <script>
            $(window).resize(function() {
            $('h1').css('z-index', 'auto'); //auto reflow
            });
        </script>
    </body>
</html>