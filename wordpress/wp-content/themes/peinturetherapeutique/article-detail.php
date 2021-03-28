
  <section class="article_list_item">
    <div class="container">
      <!--<div class="row align-items-center">
        <div class="col-lg-12 order-lg-2">
          <div class="p-5">
            <?php
              the_post_thumbnail(
                'home-thumbnail',
                array(
                  //'class' => 'img-fluid rounded-circle wp-post-image'
                  'class' => 'img-fluid'
                )
              );
            ?>
          </div>
        </div>
      </div>-->
      <div class="row align-items-center">
        <div class="col-lg-12 order-lg-1">
          <div class="p-5">
            <?php
              the_title(sprintf('<h2 class="display-4"><a href="%s">', esc_url(get_link_url())), '</a></h2>');
            ?>
            <p>
              <?php
                the_content('');
              ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
