<?php panel_breadcrumb($data->column, '/panel/section/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', []); ?>  
    <div class="col-lg-9">
        <?php $section = $data->section; ?>
        <form action="/panel/section/update" method="POST">
            <div class="row">
                <div class="col-md-10">
                    <h2>section update</h2>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-success" type="submit">update</button>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-sm btn-success" href="/panel/section/page/1">back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>created</label>
                        <input name="section_created" class="form-control" type="text" value="<?php echo $section->section_created; ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>updated</label>
                        <input class="form-control" type="text" value="<?php echo $section->section_updated; ?>" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>title</label>
                        <input name="section_title" class="form-control" type="text" minlength="3" maxlength="20" value="<?php echo $section->section_title; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>section text</label>
                        <textarea name="section_text" rows="5" minlength="3" maxlength="200" type="text" class="form-control" placeholder="section text" required id="editor1"><?php echo $section->section_text; ?></textarea>
                            <script>CKEDITOR.replace('editor1')</script>
                    </div>
                </div>
        
                <input name="section_id" type="hidden" value="<?php echo $section->section_id; ?>" required>

            </div>
        </form>
    </div>
</div>


