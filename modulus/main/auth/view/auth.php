<h3 class="mt-4 mb-3">
    <small>sign in</small>
</h3>
<?php breadcump();  ?>
<div class="row">
    <div class="col-lg-6 mb-4">
        <h3>sign in</h3>
        <form action="/signin" method="POST">
            <div class="control-group form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="user_email" required
                        <?php if(UserCookie::user_password()): ?>
                        value="<?php echo UserCookie::user_email(); ?>" 
                        <?php else: ?>
                        placeholder="email" 
                        <?php endif; ?>
                        <?php if(old::user_email()): ?>
                        value="<?php echo old::user_email(); ?>" 
                        <?php else: ?>
                        placeholder="email" 
                        <?php endif; ?>
                        >
                </div>
            </div>
            <div class="control-group form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="user_password" 
                        <?php if(UserCookie::user_password()): ?>
                        value="<?php echo UserCookie::user_password(); ?>" 
                        <?php else: ?>
                        placeholder="password" 
                        <?php endif; ?>
                        required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">sign in</button>
        </form>
    </div>
</div>