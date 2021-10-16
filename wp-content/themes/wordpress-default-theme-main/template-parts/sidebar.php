<sidebar class="sidebar js-sidebar">
  <button data-action='hide' class="sidebar__close"></button>
  <div class="sidebar__container">

    <?php
    $namespace = 'template-parts/forms';
    get_template_part("$namespace/song", 'upload');
    get_template_part("$namespace/song", 'edit');
    get_template_part("$namespace/album", 'upload');
    get_template_part("$namespace/album", 'edit');
    ?>

  </div>
</sidebar>
