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
                var show_per_page = 6; 
                var current_page = 0;

                function set_display(first, last) {
                $('#content').children().css('display', 'none');
                $('#content').children().slice(first, last).css('display', 'block');
                }

                function previous(){
                    if($('.active').prev('.page_link').length) go_to_page(current_page - 1);
                }

                function next(){
                    if($('.active').next('.page_link').length) go_to_page(current_page + 1);
                }

                function go_to_page(page_num){
                current_page = page_num;
                start_from = current_page * show_per_page;
                end_on = start_from + show_per_page;
                set_display(start_from, end_on);
                $('.active').removeClass('active');
                $('#id' + page_num).addClass('active');
                }  

                $(document).ready(function() {

                var number_of_pages = Math.ceil($('#content').children().length / show_per_page);
                
                var nav = '<ul class="pagination"><li><a href="javascript:previous();">&laquo;</a>';

                var i = -1;
                while(number_of_pages > ++i){
                    nav += '<li class="page_link'
                    if(!i) nav += ' active';
                    nav += '" id="id' + i +'">';
                    nav += '<a href="javascript:go_to_page(' + i +')">'+ (i + 1) +'</a>';
                }
                nav += '<li><a href="javascript:next();">&raquo;</a></ul>';

                $('#page_navigation').html(nav);
                set_display(0, show_per_page);
                
                });
        </script>

    </body>
</html>
