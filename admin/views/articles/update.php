<?php

use Admin\Functions;

$title = "Ajouter un article - " . ucfirst($host); ?>

<?php ob_start(); ?>
<p class="mb-3"><a class="text-dark" href="/administration">Tableau de bord</a> > <a class="text-dark" href="/administration/articles">Articles</a> > <a class="text-dark" href="/administration/articles/<?= $article['slug']; ?>"><?= $article['title']; ?></a> > Modifier</p>

<?php if (isset($articleUpdated)) : ?>
    <?php if ($articleUpdated == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Modification de l'article échoué !<br/>
            Erreur</strong> : <?= $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
<?php endif ?>

<h3 class="mb-3">Modification de l'article <strong><?= $article['title']; ?></strong></h3>

<form class="row g-3 mb-3" action="" method="post" enctype="multipart/form-data">
    <div class="col-12 col-lg-6">
        <div class="mb-2">
            <label for="author">Auteur</label>
            <select class="custom-select" id="author" name="author" required>
                <option selected value="<?= $author['id']; ?>"><?= $author['pseudonym']; ?></option>
                <?php foreach ($authors as $author) {
                    if ($article['id_author'] !== $author['id']) { ?>
                        <option value="<?= $author['id']; ?>"><?= $author['pseudonym']; ?></option>
                    <?php }
                } ?>
            </select>
        </div>
        
        <div class="mb-3">
            <p class="mb-0">Publication de l'article :</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="validate" name="validate" <?php if ($article['validate'] == 1) { ?>checked<?php } ?>>
                <label class="form-check-label" for="validate">Valider</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="visible" name="visible" <?php if ($article['visible'] == 1) { ?>checked<?php } ?>>
                <label class="form-check-label" for="visible">Visible</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="title">Titre <?php if (!empty($titleArticle) && $titleArticle !== $article['title']) : ?><span class="text-danger">(modification non enregistrée)</span><?php endif ?></label>
            <input type="text" class="form-control" id="title" name="title" maxlength="255" placeholder="Titre de l'article" value="<?php if (!empty($titleArticle)) { echo $titleArticle; } elseif (!empty($article['title'])) { echo $article['title']; } ?>" required>
        </div>

        <div class="mb-3">
            <label for="title">Slug <?php if (!empty($slugArticle) && $slugArticle !== $article['slug']) : ?><span class="text-danger">(modification non enregistrée)</span><?php endif ?></label>
            <input type="text" class="form-control" id="slug" name="slug" maxlength="255" placeholder="Slug de l'article" value="<?php if (!empty($slugArticle)) { echo $slugArticle; } elseif (!empty($article['slug'])) { echo $article['slug']; } ?>" required>
        </div>

        <div class="mb-3">
            <p class="mb-3">illustration de l'article</p>
            <img class="img-fluid w-100 rounded-4 mb-3" src="/public/img/articles/<?= $article['illustration']; ?>">
            <div class="custom-file">
                <input type="hidden" name="MAX_FILE_SIZE" value="25000000"/>
                <input type="file" class="custom-file-input" id="illustration" name="illustration">
                <label class="custom-file-label" for="illustration"><?php if (!empty($article['illustration'])) : ?><?= $article['illustration']; ?><?php else: ?>Choisir un fichier<?php endif ?></label>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label for="subtitle">Sous-titre <?php if (!empty($subtitleArticle) && $subtitleArticle !== $article['subtitle']) : ?><span class="text-danger">(modification non enregistrée)</span><?php endif ?></label>
            <textarea class="form-control" id="subtitle" name="subtitle"><?php if (!empty($subtitleArticle)) { echo $subtitleArticle; } elseif (!empty($article['subtitle'])) { echo $article['subtitle']; } ?></textarea>
        </div>

        <div class="mb-3">
            <label for="content">Contenu <?php if (!empty($contentArticle) && $contentArticle !== $article['content']) : ?><span class="text-danger">(modification non enregistrée)</span><?php endif ?></label>
            <textarea class="form-control" id="content" name="content"><?php if (!empty($contentArticle)) { echo $contentArticle; } elseif (!empty($article['content'])) { echo $article['content']; } ?></textarea>
        </div>
    </div>

    <div class="col- text-center mb-3">
        <button type="submit" class="btn btn-warning" name="updateArticleSubmit">Modifier l'article</button>
    </div>
</form>

<script>
    document.querySelector('.custom-file-input').addEventListener('change',function(e){
        var fileName = document.getElementById("illustration").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })
</script>

<script>
    tinymce.init({
    selector: '#subtitle',
    language: 'fr_FR',
    encoding: "UTF-8",
    entity_encoding : "raw",
    plugins: 'anchor autolink charmap code codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code',
    height : 250,
    promotion: false,
    });

    tinymce.init({
    selector: '#content',
    language: 'fr_FR',
    encoding: "UTF-8",
    entity_encoding : "raw",
    plugins: 'anchor autolink charmap code codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code',
    promotion: false,
    });
</script>

<script>
    function slugifyJS(text, divider = '-') {
        // replace non letter or digits by divider
        text = text.replace(/[^\w\d]+/g, divider);

        // remove unwanted characters
        text = text.replace(/[^-\w]+/g, '');

        // trim
        text = text.trim(divider);

        // remove duplicate divider
        text = text.replace(/--+/g, divider);

        // lowercase
        text = text.toLowerCase();

        if (!text) {
            return makeIdPublicJS();
        }

        return text;
    }

    function makeIdPublicJS() {
        const crypto = window.crypto || window.msCrypto;
        const array = new Uint8Array(16);
        crypto.getRandomValues(array);
        const idPublic = Array.from(array, dec => ('0' + dec.toString(16)).slice(-2)).join('');

        return idPublic;
    }

  const titleInput = document.querySelector('#title');
  const slugInput = document.querySelector('#slug');

  titleInput.addEventListener('input', function() {
    slugInput.value = slugifyJS(titleInput.value);
  });
</script>
<?php $content = ob_get_clean(); ?>

<?php require_once(__DIR__.'/../layout.php'); ?>