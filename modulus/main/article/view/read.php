<?php $article = $data->article; ?>
<h3 class="mt-4 mb-3">#<?php echo $article->article_title; ?></h3>

<?php breadcump();  ?>

<div class="row">
    <div class="col-lg-8">
        <p class="lead"><?php echo $article->article_text; ?></p>
        <hr>

        <div class="my-3">

            <div>
                <span class="badge badge-warning">
                    <span> Nəşr edilmişdir: </span>
                    <span><?php echo $article->article_created; ?></span>
                </span>

                <span class="badge badge-info">
                    <span> baxış: </span>
                    <span><?php echo $article->article_view; ?></span>
                </span>

                 <span>
                    <a class="badge badge-danger" 
                        href="/articles/<?php echo $article->section_slug; ?>/<?php echo $article->category_slug; ?>/page/1">
                        <span>category: </span>
                        <span><?php echo $article->category_title; ?></span>
                    </a>
                </span>

            </div>

            <div class="my-3">
                <?php foreach($data->keyword as $keyword): ?>
                    <a href="/article/search/data/<?php echo substr($keyword->article_slug, 0, 5); ?>/page/1" 
                        class="text-secondary ml-1">
                        #<?php echo substr($keyword->article_title,0,5); ?>
                    </a>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <?php if(User::has()): ?>
        <div class="card mb-3">
            <h5 class="card-header"><?php echo content::search(); ?></h5>
            <div class="card-body">
                <form action="/article/search/key/value">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">#</span>
                        </div>
                        <input type="text" class="form-control" name="field_value" minlength="3" maxlength="20" placeholder="Search by keyword..." required>
                        <span class="input-group-btn">
                        <button class="btn btn-secondary ml-1" type="submmit">Go!</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <?php if(count($data->similar) > 1): ?>
        <div class="card ">
            <h5 class="card-header"><?php echo content::similar(); ?></h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                            <?php foreach($data->similar[0] as $similar): ?>
                            <li>
                                <a href="/article/id/<?php echo $similar->article_id; ?>">
                                #<?php echo $similar->article_id; ?>
                                <?php echo substr($similar->article_text, 0, 7); ?>...
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                            <ul class="list-unstyled mb-0">
                                <?php foreach($data->similar[1] as $similar): ?>
                                <li>
                                    <a href="/article/id/<?php echo $similar->article_id; ?>">
                                    #<?php echo $similar->article_id; ?>
                                    <?php echo substr($similar->article_text, 0, 7); ?>...
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="card my-3">
            <h5 class="card-header"><?php echo content::reminder(); ?></h5>
            <div class="card-body">
                <?php echo Setting::reminder(); ?>
            </div>
        </div>
    </div>
</div>

