<?php
use App\Models\Comment;
use App\Functions;

$title = "Commentaires - " . ucfirst($host); ?>

<?php ob_start(); ?>
<h1>Tableau de bord</h1>
<ul>
    <li><a href="/administration/articles">Articles</a></li>
    <li><a href="/administration/commentaires">Commentaires</a></li>
</ul>
<h2><a href="/">Retourner sur le site web</a></h2>
<hr>

<h3>Liste des commentaires non validés</h3>

<?php if (!empty($commentsNotValidate)) { ?>
    <p><i>Vous pouvez valider ou supprimer les commentaires ci-dessous.</i></p>
<?php } else { ?>
    <p><i>Aucun commentaire en attente de validation.</i></p>
<?php } ?>

<div class="row g-3">
<?php foreach ($commentsNotValidate as $commentNotValidate) {
    $author = Comment::getAuthorByComment($commentNotValidate['uuid']);
?>
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">
                <p class="mb-0"><b><?= $author['pseudonym']; ?></b> - <?= Functions::creationDateLittleEndian($commentNotValidate['creation_date']); ?></p>
            </div>
            <div class="card-body">
                <p class="card-text mb-0"><?= Functions::PrintInput($commentNotValidate['comment']); ?></p>

                <form class="text-end" action="" method="POST">
                    <input type="hidden" name="commentUuid" value="<?= $commentNotValidate['uuid']; ?>">
                    
                    <button type="submit" class="btn btn-success" name="validateCommentArticleSubmit">Valider</button>
                    <button type="submit" class="btn btn-danger" name="deleteCommentArticleSubmit">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>