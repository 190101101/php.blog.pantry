<h3 class="mt-4 mb-3">article
    <small>by
        <a class="text-danger">@<?php echo $data->user->user_login; ?></a>
    </small>
</h3>
<?php breadcump();  ?>

<ul class="pagination justify-content-center">
    <?php pagination::selector($data->page, "article/user/{$data->user->user_id}/"); ?>
</ul>

<div class="row">
    <?php if($data->page->count): ?>
    <?php foreach($data->article as $article): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
        <a href="/article/read/<?php echo $article->article_id; ?>/page/1" class="card h-100 bordered border-danger">
            <div class="card-body">
                <h6 class="text-danger">
                    @<?php echo $article->user_login; ?>
                </h6>
                <p class="card-text"><?php echo substr($article->article_text, 0, 200); ?>...</p>
                <h6 class="text-center text-info">
                    #<?php echo $article->article_title; ?>
                </h6>
                <small><?php echo date_ymd($article->article_created); ?></small>
                <small>/ # <?php echo $article->article_id; ?></small>
                <small>/ baxış: <?php echo $article->article_view; ?></small>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="col-md-12">
        <div class="alert alert-warning">
            bu günə qədər heç bir nəşr yoxdur. birinci ol
        </div>
    </div>
    <?php endif; ?>
</div>
<?php if($data->page->count): ?>
<span>
    <span>found <?php echo $data->page->count ?> articles / </span>
    <span>there are <?php echo $data->page->length; ?> pages</span>
</span>
<?php endif; ?>

<ul class="pagination justify-content-center">
    <?php pagination::selector($data->page, "article/user/{$data->user->user_id}/"); ?>
</ul>