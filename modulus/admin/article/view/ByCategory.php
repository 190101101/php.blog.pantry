<?php panel_breadcrumb($data->column, '/panel/article/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', (object) [
        'page' => $data->page,
    ]); ?>  

    <div class="col-lg-9">
        <div class="row">
            <div class="col-md-6">
                <h2>article by category</h2>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>category</th>
                    <th>text</th>
                    <th>created</th>
                    <th>status</th>
                    <th>show</th>
                    <th>update</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->article as $article): ?>
                <tr>
                    <td>
                        <a 
                            <?php if($article->section_id != 1): ?>
                            href="/article/id/<?php echo $article->article_id; ?>"
                            <?php endif; ?> >
                            <?php echo $article->article_id; ?>        
                        </a>
                    </td>
                    <td>#<?php echo $article->article_title; ?></td>
                    <td>
                        <a 
                            <?php if($article->section_id != 1): ?>
                            href="/articles/<?php echo $article->section_slug; ?>/<?php echo $article->category_slug; ?>/page/1"
                            <?php endif; ?>
                            title="#id: <?php echo $article->category_id; ?>">
                            #<?php echo substr($article->category_title, 0, 10); ?>
                        </a>
                    </td>
                    <td><?php echo substr($article->article_text, 0, 10); ?></td>
                    <td><?php echo date_ymd($article->article_created); ?></td>
                    <td>
                        <label class="switch">
                        <input type="checkbox" class="data-get" 
                            data-get="/panel/article/status/<?php echo $article->article_id; ?>" 
                            <?php echo $article->article_status == 1 ? 'checked' : NULL; ?> > 
                        <span class="slider round"></span>
                        </label>
                    </td>
                    <td><a class="btn btn-sm btn-success"
                        href="/panel/article/show/<?php echo $article->article_id; ?>">show</a></td>
                    <td>
                        <a class="btn btn-sm btn-warning"
                        href="/panel/article/update/<?php echo $article->article_id; ?>">update</a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-danger data-del"
                        data-get="/panel/article/delete/<?php echo $article->article_id; ?>">delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>id</td>
                    <td>title</td>
                    <td>category</td>
                    <td>text</td>
                    <td>created</td>
                    <td>status</td>
                    <td>show</td>
                    <td>update</td>
                    <td>delete</td>
                </tr>
            </tfoot>
        </table>
        <ul class="pagination justify-content-center">
            <?php pagination::selector($data->page, "panel/articles/{$data->section}/{$data->category}/"); ?>
        </ul>
    </div>
</div>