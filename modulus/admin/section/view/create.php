<?php panel_breadcrumb($data->column, '/panel/section/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', []); ?>  
    <div class="col-lg-9">
        <form action="/panel/section/create" method="POST">
            <div class="row">
                <div class="col-md-10">
                    <h2>section show</h2>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-success" type="submit">create</button>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-sm btn-success" href="/panel/section/page/1">back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>title</label>
                        <input name="section_title" class="form-control" type="text" minlength="3" maxlength="20" placeholder="title" required>
                    </div>

                    <div class="form-group">
                        <label>section text</label>
                        <textarea name="section_text" rows="5" minlength="3" maxlength="200" type="text" class="form-control" placeholder="section text" required id="editor1"></textarea>
                        <script>CKEDITOR.replace('editor1')</script>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


