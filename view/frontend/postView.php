<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>

<header id="headerBan" class="row">
    <div class="container-fluid">
        <div class="row" id="firstLine">
            <h1 id="titleChapter" class="text-center"><?= htmlspecialchars($post['title']) ?></h1>
        </div>
        
        <div class="row" id="secondeLine">
            <h3 id="dateChapter" class="text-center">le <?= $post['creation_date_fr'] ?></h3>
        </div>
    </div> 
</header>

<div class="container">

    <p><a href="index.php">Retour à la liste des chapitres</a></p>

    <div class="chapter">    
        <div class="contentChapter">
            <?= $post['content'] ?>
        </div>
    </div>

    <h2 id="titleComment">Commentaires</h2>

    <p style="text-align: center; font-weight: bold;">Commentaire totaux : <?= count($comments); ?></p>

    <ul class="media-list">
        <?php foreach($comments as $row => $data): ?>
            <li class="media thumbnail">
                <div class="media-body">
                    <div class="pull-left"><p class="media-heading">Par <?= $data['author'] ?> (<a href="index.php?action=modifComment&amp;id=<?= $data['id']?>&amp;idp=<?= $_GET['id']?>">modifier</a>)</p></div> <div class="pull-right col-"><p>Le <?= $data['comment_date_fr'] ?></p></div>
                    <div class="col-lg-12"><p><?= $data['comment'] ?></p></div>

                    <?php if(isset($response)): ?>
                        <div class="media thumbnail  body-responv">
                            <div class="media-body">
                                <h4 class="media-heading">Animaux dangereux</h4>
                                <p>Tu délires complètement, ce sont des animaux trop dangereux pour les laisser vivre.</p>
                            </div>

                            <div class="media" style="border-top: 1px black solid;">
                                <div class="media-body">
                                    <h4 class="media-heading">Animaux dangereux</h4>
                                    <p>Tu délires complètement, ce sont des animaux trop dangereux pour les laisser vivre.</p>
                                </div>       
                            </div>

                            <div class="media" style="border-top: 1px black solid;">
                                <div class="media-body">
                                    <h4 class="media-heading">Animaux dangereux</h4>
                                    <p>Tu délires complètement, ce sont des animaux trop dangereux pour les laisser vivre.</p>
                                </div>
                            </div>  
                        </div>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
        <div class="divPost">
            <label for="author" class="labelPostAuthor">Auteur</label>
            <input type="text" id="author" name="author" class="inputPostAuthor"/>
        </div>

        <div class="divPost">
            <label for="comment" class="labelPostComment">Commentaire</label>
            <textarea id="comment" name="comment" class="inputPostComment"></textarea>
        </div>

        <div>
            <input class="btn btn-primary" type="submit" />
        </div>
    </form>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
