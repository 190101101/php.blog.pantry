<h3 class="mt-4 mb-3"><?php echo content::search_by(); ?>
    <small>
        <a class="text-danger">#<?php echo $data->search->value; ?></a>
    </small>
</h3>

<?php breadcump();  ?>

<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <?php include(MW.'article.php'); ?>
        </div>

        <ul class="pagination justify-content-center">
            <?php pagination::selector($data->page, breadcump_search()); ?>
        </ul>

        <?php include(MW.'info.php'); ?>
        
    </div>

    <?php include(MW.'section.php'); ?>
</div>

