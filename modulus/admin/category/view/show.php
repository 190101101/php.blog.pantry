<?php panel_breadcrumb($data->column, '/panel/category/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', []); ?>  
    <div class="col-lg-9">
        <?php $category = $data->category; ?>
        <div class="row">
            <div class="col-md-10">
                <h2>category show</h2>
            </div>
            <div class="col-md-1">
                <a href="/panel/category/update/<?php echo $category->category_id; ?>" class="btn btn-sm btn-warning">update</a>
            </div>
            <div class="col-md-1">
                <a class="btn btn-sm btn-success" href="/panel/category/page/1">back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>id</label>
                    <input class="form-control" value="<?php echo $category->category_id; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>title</label>
                    <input class="form-control" value="<?php echo $category->category_title; ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>created</label>
                    <input type="text" class="form-control" value="<?php echo $category->category_created; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>updated</label>
                    <input type="text" class="form-control" value="<?php echo $category->category_updated; ?>" readonly>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>category text</label>
                    <textarea name="category_text" rows="5" minlength="3" maxlength="200" type="text" class="form-control" placeholder="category text" required id="editor1"><?php echo $category->category_text; ?></textarea>
                        <script>CKEDITOR.replace('editor1')</script>
                </div>
            </div>
            <!--  -->
            <div class="col-md-12 mt-3">
                <a class="btn btn-sm btn-outline-danger"
                    href="/panel/category/destroy/<?php echo $category->category_id; ?>">delete</a>
            </div>
            <!--  -->
        </div>
    </div>
</div>

