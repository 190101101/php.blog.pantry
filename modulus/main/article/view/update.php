<?php breadcump(); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('main', 'requires', 'main/sidebar', []); ?>  
    
    <div class="col-lg-9">
        <?php $article = $data->article; ?>
        <form action="/article/update" method="POST">
            <div class="row">
                <div class="col-lg-10">
                    <h2>article update</h2>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-sm btn-success" type="submit">update</button>
                    <a class="btn btn-sm btn-success" href="/article/page/1">back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>id</label>
                        <input class="form-control" value="<?php echo $article->article_id; ?>"  required readonly>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>created</label>
                        <input type="text" class="form-control" value="<?php echo $article->article_created; ?>" required readonly>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>updated</label>
                        <input type="text" class="form-control" value="<?php echo $article->article_updated; ?>" required readonly>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>title</label>
                        <input name="article_title" class="form-control" type="text" value="<?php echo $article->article_title; ?>" required>
                    </div>
                </div>
                <div class="col-lg-12">
                    <label>article text</label>
                    <textarea name="article_text" type="text" minlength="100" maxlength="30000" class="form-control" placeholder="article text" required id="editor1"><?php echo $article->article_text; ?></textarea>
                        <script>CKEDITOR.replace('editor1')</script>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>type</label>
                        <select class="form-control" name="article_type" required>
                            <option value="<?php echo $article->article_type ?>" selected>
                                <?php echo $article->article_type ? 'public' : 'draft'; ?>
                            </option>
                            <option value="1">public</option>
                            <option value="0">draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>category</label>
                        <select class="form-control" name="category_id" required>
                            <option value="<?php echo $article->category_id; ?>" selected>
                                <?php echo $article->category_title; ?>
                            </option>
                            <?php foreach($data->category as $category): ?>
                                <option value="<?php echo $category->category_id; ?>">
                                    <?php echo $category->category_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <input name="article_id" type="hidden" value="<?php echo $article->article_id; ?>"  required readonly>
            </div>
        </form>
    </div>
</div>