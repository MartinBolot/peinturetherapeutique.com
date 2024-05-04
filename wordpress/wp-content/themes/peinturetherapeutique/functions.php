<?php

function register_main_menu() {
  register_nav_menu('navigation-menu',__( 'Navigation principale' ));
}
add_action( 'init', 'register_main_menu' );


add_theme_support( 'post-formats', array(
   'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
) );

add_theme_support('post-thumbnails');

function add_custom_sizes() {
    add_image_size('home-thumbnail', 1000, 1000, array('left', 'top'));
}
add_action('after_setup_theme','add_custom_sizes');


/* Redéfinition Walker menu */
class Walker_custom extends Walker_Nav_Menu {
  public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

  public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat( $t, $depth );

    // Default class.
    $classes = array( 'sub-menu' );
    $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
    $class_names = $class_names ? ' class=" navbar-nav ml-auto ' . esc_attr( $class_names ) . '"' : '';

    $output .= "{$n}{$indent}<ul$class_names>{$n}";
  }

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat( $t, $depth );
    $output .= "$indent</ul>{$n}";
  }

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;

    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
    $class_names = ' class="nav-item"';

  //$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
  //$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
    $id = '';

    $output .= $indent . '<li' . $id . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
    $atts['class'] = 'nav-link';

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . $item->title . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  public function end_el( &$output, $item, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
      $output .= "</li>{$n}";
  }

}

function post_thumbnail() {
   if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
       return;
   }

   if ( is_singular() ) :
   ?>

   <div class="post-thumbnail">
       <?php the_post_thumbnail(); ?>
   </div><!-- .post-thumbnail -->

   <?php else : ?>
   <?php
       the_post_thumbnail(
           'post-thumbnail',
           array(
               'alt' => get_the_title(),
               //'class' => 'img-fluid rounded-circle'
               'class' => 'img-fluid'
           )
        );
   ?>

   <?php endif; // End is_singular()
}

function get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}


function entry_meta() {
   if ( is_sticky() && is_home() && ! is_paged() ) {
       printf( '<span class="sticky-post">%s</span>', __( 'Featured', 'lebourdonnement' ) );
   }

   $format = get_post_format();
   if ( current_theme_supports( 'post-formats', $format ) ) {
       printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
           sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'lebourdonnement' ) ),
           esc_url( get_post_format_link( $format ) ),
           get_post_format_string( $format )
       );
   }

   if ( 'post' == get_post_type() ) {
       if ( is_singular() || is_multi_author() ) {
           printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
               _x( 'Author', 'Used before post author name.', 'lebourdonnement' ),
               esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
               get_the_author()
           );
       }

       $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'lebourdonnement' ) );
       if ( $categories_list && categorized_blog() ) {
           printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
               _x( 'Categories', 'Used before category names.', 'lebourdonnement' ),
               $categories_list
           );
       }

       $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'lebourdonnement' ) );
       if ( $tags_list && ! is_wp_error( $tags_list ) ) {
           printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
               _x( 'Tags', 'Used before tag names.', 'lebourdonnement' ),
               $tags_list
           );
       }
   }

   if ( is_attachment() && wp_attachment_is_image() ) {
       // Retrieve attachment metadata.
       $metadata = wp_get_attachment_metadata();

       printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
           _x( 'Full size', 'Used before full size attachment link.', 'lebourdonnement' ),
           esc_url( wp_get_attachment_url() ),
           $metadata['width'],
           $metadata['height']
       );
   }
}

function categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'lebourdonnement_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'lebourdonnement_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 || is_preview() ) {
		// This blog has more than 1 category so lebourdonnement_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so lebourdonnement_categorized_blog should return false.
		return false;
	}
}

function my_mce_buttons_3( $buttons ) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_3', 'my_mce_buttons_3');

function my_mce_before_init_insert_formats( $init_array ) {
  $style_formats = array(
    array(
      'title' => 'chapo',
      'block' => 'p',
      'classes' => 'chapo',
      'wrapper' => false,
    ),
    array(
      'title' => 'section',
      'block' => 'section',
      'classes' => '',
      'wrapper' => true,
    ),
    array(
      'title' => 'row',
      'block' => 'div',
      'classes' => 'row',
      'wrapper' => true,
    ),
    array(
      'title' => 'container',
      'block' => 'div',
      'classes' => 'container',
      'wrapper' => true,
    ),
    array(
      'title' => 'col-md-12',
      'block' => 'div',
      'classes' => 'col-md-12',
      'wrapper' => true,
    ),
    array(
      'title' => 'figcaption',
      'block' => 'figcaption',
      'classes' => '',
      'wrapper' => true,
    ),
  );
  $init_array['style_formats'] = json_encode( $style_formats );
  return $init_array;
}
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

function my_format_TinyMCE( $in ) { return $in; }

add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );

function html5_insert_image($html, $id, $caption, $title, $align, $url) {
    $url = wp_get_attachment_url($id);
    $html5 = "<figure id='post-$id media-$id' class='align-$align'>";
    $html5 .= "<img src='$url' alt='$title' />";
    if ($caption) {
        $html5 .= "<figcaption class='figure-caption text-center'>$caption</figcaption>";
    }
    $html5 .= "</figure>";
    return $html5;
}
add_filter( 'image_send_to_editor', 'html5_insert_image', 10, 9 );
