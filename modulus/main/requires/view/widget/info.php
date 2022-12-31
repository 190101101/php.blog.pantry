<?php if($data->page->count): ?>
<span>
    <span>
        <?php echo content::found_data(); ?>
        <?php echo $data->page->count ?>
    </span>
    /
    <span>
        <?php echo content::pages_found(); ?>
        <?php echo $data->page->length; ?>
    </span>
</span>
<?php endif; ?>