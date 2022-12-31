<?php panel_breadcrumb($data->column, '/panel/section/search/key/value'); ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar', (object) [
        'page' => $data->page,
        'search' => $data->search
    ]); ?>  
    <div class="col-lg-9">
        <div class="row">
            <div class="col-md-6">
                <h2>section search for: <?php echo segment(6); ?></h2>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>created</th>
                    <th>show</th>
                    <th>update</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->section as $section): ?>
                <tr>
                    <td><?php echo $section->section_id; ?></td>
                    <td>
                        <a href="/panel/articles/<?php echo $section->section_slug; ?>/<?php echo $section->section_slug; ?>/page/1">
                            #<?php echo $section->section_title; ?>
                        </a>
                    </td>
                    <td><?php echo date_ymd($section->section_created); ?></td>
                    <td><a class="btn btn-sm btn-success"
                        href="/panel/section/show/<?php echo $section->section_id; ?>">show</a></td>
                    <td><a class="btn btn-sm btn-warning"
                        href="/panel/section/update/<?php echo $section->section_id; ?>">update</a></td>
                    <td><a class="btn btn-sm btn-danger data-del"
                        data-get="/panel/section/delete/<?php echo $section->section_id; ?>">delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>id</td>
                    <td>title</td>
                    <td>created</td>
                    <td>show</td>
                    <td>update</td>
                    <td>delete</td>
                </tr>
            </tfoot>
        </table>

        <ul class="pagination justify-content-center">
            <?php pagination::selector($data->page, breadcump_search()); ?>
        </ul>
    </div>
</div>