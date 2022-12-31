<?php breadcump(); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('main', 'requires', 'main/sidebar', (object) [
        'data' => 'page_data',
        'page' => $data->page
    ]); ?>  
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <h3>article</h3>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>text</th>
                    <th>created</th>
                    <th>show</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->article as $article): ?>
                <tr>
                    <td><?php echo $article->article_id; ?></td>
                    <td>#<?php echo $article->article_title; ?></td>
                    <td><?php echo substr($article->article_text, 0, 10); ?></td>
                    <td><?php echo date_ymd($article->article_created); ?></td>
                    <td><a class="btn btn-sm btn-success"
                        href="/article/id/<?php echo $article->article_id; ?>">show</a></td>
                    <td><a class="btn btn-sm btn-danger data-del"
                        data-get="/article/delete/<?php echo $article->save_id; ?>">delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>id</td>
                    <td>title</td>
                    <td>text</td>
                    <td>created</td>
                    <td>show</td>
                    <td>delete</td>
                </tr>
            </tfoot>
        </table>

        <?php if(!$data->page->count): ?>
            <div class="alert alert-info">
                <?php echo content::article_create(); ?>
            </div>
        <?php endif; ?>
        <ul class="pagination justify-content-center">
            <?php pagination::selector($data->page, 'article/'); ?>
        </ul>
    </div>
</div>