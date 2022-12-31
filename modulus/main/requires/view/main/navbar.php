<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand text-white" 
      <?php if(User::has()): ?>
        href="/panel/admin"
      <?php endif; ?>
      ><?php echo content::nav(); ?></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link <?php echo segment(1) != '' ?: 'active'; ?>" href="/">home</a>
          </li>

         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo content::other_pages(); ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
              <a class="dropdown-item" href="/mode/<?php echo css_mode()->code; ?>">
                <?php echo css_mode()->css_mode == 'dark' ? content::light() : content::dark(); ?>
              </a>

              <?php if(Setting::about_page_status() == 1): ?>
              <a class="dropdown-item <?php echo segment(2) != 'about' ?: 'active'; ?>" href="/info/about"><?php echo content::about(); ?></a>
              <?php endif; ?>

            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>


