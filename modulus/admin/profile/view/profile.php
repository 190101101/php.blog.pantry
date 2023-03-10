<?php breadcump();  ?>
<div class="row">
    <?php $main = new core\controller; ?>
    <?php $main->view('admin', 'requires', 'admin/sidebar'); ?>
    <div class="col-lg-9 mb-4">
        <form action="/panel/profile/update" method="POST">
            <div class="row">
                <div class="col-md-10">
                    <h2>profile update</h2>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-success" type="submit">update</button>
                    <a class="btn btn-sm btn-success" href="/panel/admin">back</a>
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <input class="form-control" value="<?php echo User::user_password(); ?>"disabled>
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="user_password" placeholder="password" required>
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="confirm_password" placeholder="confirm password" required>
                </div>
            </div>
        </form>
    </div>
</div>