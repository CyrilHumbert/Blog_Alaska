<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <link rel="icon" href="public/images/favicon1.gif" type="image/gif">
        <link href="public/css/bootstrap.css" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet">   
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
                <div id="linkFooterDisconnect" class="col-xs-offset-4 col-xs-2 col-sm-offset-8 col-md-offset-8 col-lg-offset-9 col-lg-1">
                    <a href="index.php?action=disconnect" id="linkDisconnect">
                        Déconnexion
                    </a>
                </div>
            <?php endif ?> 
        </footer>

        <script>
            $(function(){

                /* AJOUT D'UN COMMENTAIRE QUI N'EST PAS UNE REPONSE */
                $(".inputPostComment").focus(function() {
                $(".labelPostComment").addClass('active');
                $(".inputPostComment").css({
                    "border-color": "#33cc33",
                    "border-bottom-width": "2px",
                    "outline": "0"
                    });
                });

                $(".inputPostAuthor").focus(function() {
                $(".labelPostAuthor").addClass('active');
                $(".inputPostAuthor").css({
                    "border-color": "green",
                    "border-bottom-width": "2px",
                    "outline": "0"
                    });
                });

                $(".inputPostComment").focusout(function() {
                    if($(".inputPostComment").val().length > 0) {
                        $(".labelPostComment").addClass('active');
                        $(".inputPostComment").css({
                            "border-color": "#33cc33",
                            "border-bottom-width": "2px",
                            "outline": "0"
                            });
                    }else {
                        $(".labelPostComment").removeClass('active');
                        $(".inputPostComment").css({
                        "border-color": "",
                        "border-bottom-width": "",
                        "outline": ""
                        });  
                    }
                });

                $(".inputPostAuthor").focusout(function() {
                    if($(".inputPostAuthor").val().length > 0) {
                        $(".labelPostAuthor").addClass('active');
                        $(".inputPostAuthor").css({
                            "border-color": "green",
                            "border-bottom-width": "2px",
                            "outline": "0"
                            });
                    }else {
                        $(".labelPostAuthor").removeClass('active');
                        $(".inputPostAuthor").css({
                        "border-color": "",
                        "border-bottom-width": "",
                        "outline": ""
                        });  
                    }
                });

                if($(".inputPostComment").val().length > 0) {
                    $(".labelPostComment").addClass('active');
                    $(".inputPostComment").css({
                        "border-color": "#33cc33",
                        "border-bottom-width": "2px",
                        "outline": "0"
                        });
                }
                
                if($(".inputPostAuthor").val().length > 0) {
                    $(".labelPostAuthor").addClass('active');
                    $(".inputPostAuthor").css({
                        "border-color": "green",
                        "border-bottom-width": "2px",
                        "outline": "0"
                        });
                }
            });
        </script>
    </body>
</html>