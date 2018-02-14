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
        <script src="public/js/tinymce/tinymce.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            tinyMCE.init({
                language : "fr_FR",
                selector: "textarea#editer",
                theme: "modern",
                branding: false,
                height: 500,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
            ],
            content_css: "css/content.css",
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | searchreplace fullscreen", 
            style_formats: [
                    {title: 'Bold text', inline: 'b'},
                    {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                    {title: 'Example 1', inline: 'span', classes: 'example1'},
                    {title: 'Example 2', inline: 'span', classes: 'example2'},
                    {title: 'Table styles'},
                    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                ]
            }); 
        </script>
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

        <?= $content; ?>

        <footer>
            <nav class="footer row">
                <div id="linkFooterAdmin" class="col-sm-2">
                    <a href="<?php if(isset($_SESSION['connected'])): ?>index.php?action=administration <?php else: ?>index.php?action=login<?php endif ?>" class="test" id="linkAdmin">
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
            $(window).resize(function() {
            $('h1').css('z-index', 'auto'); //auto reflow
            });

            $(".inputEditerTitle").focus(function() {
            $(".labelEditerTitle").addClass('active');
            $(".inputEditerTitle").css({
                "border-color": "red",
                "border-bottom-width": "2px",
                "outline": "0"
                });
            });

            $(".inputEditerAuthor").focus(function() {
            $(".labelEditerAuthor").addClass('active');
            $(".inputEditerAuthor").css({
                "border-color": "green",
                "border-bottom-width": "2px",
                "outline": "0"
                });
            });

            $(".inputEditerTitle").focusout(function() {
                if($(".inputEditerTitle").val().length > 0) {
                    $(".labelEditerTitle").addClass('active');
                    $(".inputEditerTitle").css({
                        "border-color": "red",
                        "border-bottom-width": "2px",
                        "outline": "0"
                        });
                }else {
                    $(".labelEditerTitle").removeClass('active');
                    $(".inputEditerTitle").css({
                    "border-color": "",
                    "border-bottom-width": "",
                    "outline": ""
                    });  
                }
            });

            $(".inputEditerAuthor").focusout(function() {
                if($(".inputEditerAuthor").val().length > 0) {
                    $(".labelEditerAuthor").addClass('active');
                    $(".inputEditerAuthor").css({
                        "border-color": "green",
                        "border-bottom-width": "2px",
                        "outline": "0"
                        });
                }else {
                    $(".labelEditerAuthor").removeClass('active');
                    $(".inputEditerAuthor").css({
                    "border-color": "",
                    "border-bottom-width": "",
                    "outline": ""
                    });  
                }
            });

        </script>
    </body>
</html>