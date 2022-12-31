<?php panel_breadcrumb($data->column, '/panel/article/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', []); ?>  
    <div class="col-md-9">
        <form action="/panel/article/create" method="POST">
            <div class="row">
                <div class="col-md-10">
                    <h2>article create</h2>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-success" type="submit">create</button>
                    <a class="btn btn-sm btn-success" href="/panel/article/page/1">back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>title</label>
                        <input name="article_title" class="form-control" type="text" minlength="3" maxlength="100" placeholder="title" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <label>article text</label>
                    <textarea name="article_text" rows="5" minlength="10" maxlength="30000" type="text" class="form-control" placeholder="article text" required id="editor1"></textarea>
                    <script>CKEDITOR.replace('editor1')</script>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>category</label>
                        <select class="form-control" name="category_id" required>
                            <?php foreach($data->category as $category): ?>
                            <option value="<?php echo $category->category_id; ?>">
                                <?php echo $category->category_title; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


