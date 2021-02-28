
<nav id="main_nav" class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="collapse navbar-collapse">
      <?php
          $customWalker = new Walker_custom();
          // Primary navigation menu.
          wp_nav_menu(array(
              'menu_class' => 'navbar-nav ml-auto',
              'theme_location' => 'navigation-menu',
              'container' => '',
              'items_wrap' => '<ul class="navbar-nav justify-content-center">%3$s</ul>',
              'walker' => $customWalker
          ));
      ?>
  </div>
</nav>
