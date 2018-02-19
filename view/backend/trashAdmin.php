<?php $title = "Pannel d'administration - Corbeille"; ?>

<?php ob_start(); ?>

<div class="container">

    <div class="row">
        <h2 class="text-center">Chapitres supprimés</h2>
    </div>

    <table id="tableAdminChapiter" class="table table-bordered table-striped table-condensed">
            <tr>
                <th class="text-center lineTitle">Titre du chapitre</th>
                <th class="text-center">Nombre de vues</th>
                <th class="text-center">Auteur</th>
                <th class="text-center">Action</th>
            </tr>

            <?php foreach($listPosts as $row => $data): ?>
                <tr>
                    <td class="text-center lineTitle"><?= $data['title'] ?></td>
                    <td class="text-center"><?= $data['nb_views'] ?></td>
                    <td class="text-center lineAuthor"><?= $data['author'] ?></td>
                    <td class="text-center">
                    <span data-toggle="tooltip" data-placement="top" title="Restaurer le chapitre" class="spanTool"><a data-toggle="modal" href="#infosRestore<?= $data['id'] ?>" class="btn btn-success">Restaurer</a></span>
                        <!-- Modal restauration d'un chapitre -->
                        <div class="modal fade" id="infosRestore<?= $data['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>

                                    <div class="modal-body">
                                        Voulez-vous vraiment restaurer ce chapitre ?<br>
                                        Celui-ci sera restauré avec son ancien état ainsi que tous ses commentaires.
                                    </div>

                                    <div class="modal-footer">
                                        <a href="index.php?action=administration&amp;trash&amp;restore&amp;id=<?= $data['id_chapter'] ?>" class="btn btn-info pull-left">Restaurer</a>
                                        <a class="btn btn-info" data-dismiss="modal">Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN MODAL -->
                        <a href="index.php?action=administration&amp;trash&amp;deletetrash&amp;id=<?= $data['id'] ?>" class="btn btn-danger">Supprimer définitivement</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templateAdmin.php'); ?>