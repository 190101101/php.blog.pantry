<div style="margin-bottom: 25%;"></div>
<footer class="py-2 bg-dark">
  <div class="container">
    <?php if(!user::has()): ?>
      <p class="m-0 text-center text-white">  
      <a href="/auth" class="text-white">
        <?php echo Setting::copyright(); ?>
      </a>
      </p>
    <?php endif; ?>
  </div>
</footer>
