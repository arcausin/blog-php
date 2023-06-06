<?php

use Admin\Functions;

 $title = "Supprimer un article - " . ucfirst($host); ?>

<?php ob_start(); ?>
<h1>Tableau de bord</h1>
<ul>
    <li><a href="/administration/articles">Articles</a></li>
    <li><a href="/administration/commentaires">Commentaires</a></li>
</ul>
<h2><a href="/">Retourner sur le site web</a></h2>
<hr>
<div class="mb-2">
    <a href="/administration/articles">Retourner sur la liste des articles</a>
</div>

<?php if (isset($articleUpdated)) : ?>
    <?php if ($articleUpdated == false && !empty($message)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Suppression de l'article échoué !<br/>
            Erreur</strong> : <?= $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
<?php endif ?>

<h3 class="mb-3">Supprimer l'article <strong><?= $article['title']; ?></strong></h3>

<form class="row mb-3" action="" method="post" enctype="multipart/form-data">
    <div class="col-8">
        <img class="shadow img-fluid rounded-4 mb-2" src="/public/img/articles/<?= $article['illustration']; ?>" alt="">
        
        <p class="mb-2"><?= Functions::PrintContentsArticle($article['subtitle']); ?></p>

        <hr>

        <p class="mb-2"><?= Functions::PrintContentsArticle($article['content']); ?></p>
    </div>

    <div class="col- text-center">
        <button type="submit" class="btn btn-danger" name="deleteArticleSubmit">Supprimer l'article</button>
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
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    tinymce.init({
    selector: '#content',
    language: 'fr_FR',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
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