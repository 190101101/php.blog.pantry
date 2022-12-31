<?php panel_breadcrumb($data->column, '/panel/category/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', []); ?>  
    <div class="col-lg-9">
        <form action="/panel/category/create" method="POST">
            <div class="row">
                <div class="col-md-10">
                    <h2>category create</h2>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-success" type="submit">create</button>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-sm btn-success" href="/panel/category/page/1">back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>title</label>
                        <input name="category_title" class="form-control" type="text" minlength="3" maxlength="20" placeholder="title" required>
                    </div>

                    <div class="form-group">
                        <label>category text</label>
                        <textarea name="category_text" rows="5" minlength="3" maxlength="200" type="text" class="form-control" placeholder="category text" required id="editor1"></textarea>
                        <script>CKEDITOR.replace('editor1')</script>
                    </div>
                    
                    <div class="form-group">
                        <label>section</label>
                        <select class="form-control" name="section_id" required>
                            <?php foreach($data->section as $section): ?>
                            <option value="<?php echo $section->section_id; ?>">
                                <?php echo $section->section_title; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


