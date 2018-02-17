<?php $title = "Pannel d'administration"; ?>

<?php ob_start(); ?>

<div id="containerListerChapiter" class="container">
    <a href="index.php">Retour vers l'accueil du site</a>

    <div class="row">
        <h2 class="col-sm-offset-4 col-sm-3">Liste des chapitres</h2>
        <a class="btn btn-primary btnAdd" href="index.php?action=administration&amp;editer&amp;id=0" data-toggle="tooltip" data-placement="right" title="Ajoutez un chapitre"><i class="fas fa-plus-circle fa-4x"></i></a>
    </div>

    <div class="row">
        <table id="tableAdminChapiter" class="table table-bordered table-striped table-condensed">
            <tr>
                <th class="text-center lineTitle">Titre du chapitre</th>
                <th class="text-center">Auteur</th>
                <th class="text-center">Modification</th>
            </tr>

            <?php foreach($listPosts as $raw => $data): ?>
                <tr>
                    <td class="text-center lineTitle"><?= $data['title'] ?></td>
                    <td class="text-center lineAuthor"><?= $data['author'] ?></td>
                    <td class="text-center">
                        <a href="index.php?action=administration&amp;editer&amp;id=<?= $data['id'] ?>" class="btn btn-primary">Modifier</a>
                        <a data-toggle="modal" href="#infos<?= $data['id'] ?>" class="btn btn-primary">Supprimer</a>
                        <div class="modal fade" id="infos<?= $data['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer ce chapitre ?<br>
                                        Celui-ci sera placé dans la corbeille ainsi que les commentaires lié à celui-ci.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;delete&amp;id=<?= $data['id'] ?>" class="btn btn-info pull-left">Supprimer</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="row">
        <h2 class="col-sm-offset-4 col-sm-2">Corbeille</h2>
        <a href="index.php?action=administration&amp;trash" class="linkTrash col-sm-1" >Vider</a>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>