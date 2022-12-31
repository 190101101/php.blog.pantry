<h3 class="mt-4 mb-3">home 
    <small>page</small>
</h3>
<?php breadcump();  ?>
<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <?php include(MW.'article.php'); ?>
        </div>
                
        <ul class="pagination justify-content-center">
            <?php pagination::selector($data->page, 'home/'); ?>
        </ul>

        <?php include(MW.'info.php'); ?>
    
    </div>

    <?php include(MW.'section.php'); ?>
</div>
