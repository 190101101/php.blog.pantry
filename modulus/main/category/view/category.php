<h3 class="mt-4 mb-3">
    <small><?php echo content::categories(); ?></small>
</h3>
<?php breadcump();  ?>

<div class="row">
    <?php if($data->page->count): ?>
    <?php foreach($data->category as $category): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
        <a href="/articles/<?php echo $category->section_slug; ?>/<?php echo $category->category_slug; ?>/page/1" class="card h-100">
            <div class="card-body">
                <h6 class="text-center">
                    #<?php echo $category->category_title; ?>
                </h6>
                <p class="card-text"><?php echo substr($category->category_text, 0, 200); ?>...</p>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="col-md-12">
        <div class="alert alert-warning">
            <?php echo content::category_empty(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include(MW.'info.php'); ?>

<ul class="pagination justify-content-center">
    <?php pagination::selector($data->page, "category/"); ?>
</ul>

