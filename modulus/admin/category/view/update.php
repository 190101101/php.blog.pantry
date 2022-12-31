<?php panel_breadcrumb($data->column, '/panel/category/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', []); ?>  
    <div class="col-lg-9">
        <?php $category = $data->category; ?>
        <form action="/panel/category/update" method="POST">
            <div class="row">
                <div class="col-md-10">
                    <h2>category update</h2>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-success" type="submit">update</button>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-sm btn-success" href="/panel/category/page/1">back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>created</label>
                        <input name="category_created" class="form-control" type="text" value="<?php echo $category->category_created; ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>updated</label>
                        <input class="form-control" type="text" value="<?php echo $category->category_updated; ?>" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>title</label>
                        <input name="category_title" class="form-control" type="text" minlength="3" maxlength="20" value="<?php echo $category->category_title; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>category text</label>
                        <textarea name="category_text" rows="5" minlength="3" maxlength="200" type="text" class="form-control" placeholder="category text" required id="editor1"><?php echo $category->category_text; ?></textarea>
                            <script>CKEDITOR.replace('editor1')</script>
                    </div>

                    <div class="form-group">
                        <label>section</label>
                        <select class="form-control" name="section_id" required>
                            <option value="<?php echo $category->section_id; ?>" selected>
                                <?php echo $category->section_title; ?>
                            </option>
                            <?php foreach($data->section as $section): ?>
                            <option value="<?php echo $section->section_id; ?>">
                                <?php echo $section->section_title; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
        
                <input name="category_id" type="hidden" value="<?php echo $category->category_id; ?>" required>
                <input name="old_section_id" type="hidden" value="<?php echo $category->section_id; ?>" required>

            </div>
        </form>
    </div>
</div>


