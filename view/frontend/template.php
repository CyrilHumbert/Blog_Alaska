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

        <?= $content; ?>

        <footer>
            <nav class="footer row">
                <div id="linkFooterAdmin" class="col-sm-2">
                    <a href="<?php if(isset($_SESSION['connected'])): ?>index.php?action=administration <?php else: ?>index.php?action=login<?php endif ?>" id="linkAdmin">
                        Administration
                    </a>
                </div>
                
                <?php if (isset($_SESSION['connected'])): ?>
                    <div id="linkFooterDisconnect" class="col-sm-1 pull-right">
                        <a href="index.php?action=disconnect" id="linkDisconnect">
                            Déconnexion
                        </a>
                    </div>
                <?php endif ?> 
            </nav>
        </footer>

        <script>
            $(function(){

                /* AJOUT D'UN COMMENTAIRE QUI N'EST PAS UNE REPONSE */
                $(".inputPostComment").focus(function() {
                $(".labelPostComment").addClass('active');
                $(".inputPostComment").css({
                    "border-color": "red",
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
                            "border-color": "red",
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
                        "border-color": "red",
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

                /* AJOUT D'UN COMMENTAIRE QUI EST UNE REPONSE */
                $(".inputPostCommentResponse").focus(function() {
                $(".labelPostCommentResponse").addClass('active');
                $(".inputPostCommentResponse").css({
                    "border-color": "red",
                    "border-bottom-width": "2px",
                    "outline": "0"
                    });
                });

                $(".inputPostAuthorResponse").focus(function() {
                $(".labelPostAuthorResponse").addClass('active');
                $(".inputPostAuthorResponse").css({
                    "border-color": "green",
                    "border-bottom-width": "2px",
                    "outline": "0"
                    });
                });

                $(".inputPostCommentResponse").focusout(function() {
                    if($(".inputPostCommentResponse").val().length > 0) {
                        $(".labelPostCommentResponse").addClass('active');
                        $(".inputPostCommentResponse").css({
                            "border-color": "red",
                            "border-bottom-width": "2px",
                            "outline": "0"
                            });
                    }else {
                        $(".labelPostCommentResponse").removeClass('active');
                        $(".inputPostCommentResponse").css({
                        "border-color": "",
                        "border-bottom-width": "",
                        "outline": ""
                        });  
                    }
                });

                $(".inputPostAuthorResponse").focusout(function() {
                    if($(".inputPostAuthorResponse").val().length > 0) {
                        $(".labelPostAuthorResponse").addClass('active');
                        $(".inputPostAuthorResponse").css({
                            "border-color": "green",
                            "border-bottom-width": "2px",
                            "outline": "0"
                            });
                    }else {
                        $(".labelPostAuthorResponse").removeClass('active');
                        $(".inputPostAuthorResponse").css({
                        "border-color": "",
                        "border-bottom-width": "",
                        "outline": ""
                        });  
                    }
                });

                if($(".inputPostCommentResponse").val().length > 0) {
                    $(".labelPostCommentResponse").addClass('active');
                    $(".inputPostCommentResponse").css({
                        "border-color": "red",
                        "border-bottom-width": "2px",
                        "outline": "0"
                        });
                }
                
                if($(".inputPostAuthorResponse").val().length > 0) {
                    $(".labelPostAuthorResponse").addClass('active');
                    $(".inputPostAuthorResponse").css({
                        "border-color": "green",
                        "border-bottom-width": "2px",
                        "outline": "0"
                        });
                }
            });
        </script>
    </body>
</html>