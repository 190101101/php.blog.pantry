<?php $article = $data->article; ?>
<div class="list-group mt-3">
    <a class="list-group-item">article info</a>
    <a class="list-group-item" href="/panel/article/show/<?php echo $article->article_id; ?>">
        go to article: <?php echo $article->article_id; ?>
    </a>
    <a class="list-group-item">title: <?php echo $article->article_title; ?></a>
</div>