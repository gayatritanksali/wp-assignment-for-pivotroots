<?php

/* Template Name: galleryTemplate */ 

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <?php
    if ( is_sticky() && is_home() && ! is_paged() ) {
      printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'twentynineteen' ) );
    }
    if ( is_singular() ) :
      the_title( '<h1 class="entry-title">', '</h1>' );
    else :
      the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    endif;
    ?>
  </header><!-- .entry-header -->

  <?php twentynineteen_post_thumbnail(); ?>

  <div class="entry-content">
    <?php

    if(is_user_logged_in()){
    $args = array(
      'post_type'   => 'user_images',
      'post_status' => 'publish',
     );

    $user_images = new WP_Query( $args );
    if( $user_images->have_posts() ) :
    ?>
      <ul class="img_gallery_list">
        <?php
          while( $user_images->have_posts() ) :
            $user_images->the_post();
            ?>
              <?php $current_country = $current_user->country; ?>
              <?php if (get_the_author_meta('country') == $current_country) : ?> 
              <li>
                <div class="img_thumb">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_post_thumbnail_url(); ?>" title="<?php the_title_attribute(); ?>" class="lsb-preview" data-lsb-group="header">
                    <img src="<?php the_post_thumbnail_url(thumbnail); ?>"/>
                    </a>
                  <?php endif; ?>
                  </a>
                </div>
                <h2 class="img_title"><?php printf( '%1$s %2$s', get_the_title(), get_the_content() );  ?></h2>
                <?php //the_author(); ?>
                <div class="current_user_country"><?php $current_user = wp_get_current_user();
                  //echo 'User ID: ' . $current_user->ID . '<br />';

                  //$all_meta_for_user = get_user_meta( $current_user->ID );

                  //echo 'Current country: ' . $current_user->country . '<br />';
                  echo 'Country: ' . get_the_author_meta('country');
                ?></div>
              </li>
          <?php endif; ?>
          <?php
          endwhile;
          wp_reset_postdata();
          ?>
      </ul>
  <?php
  else :
    esc_html_e( 'No user images to show', 'text-domain' );
  endif;
  }
  if(!is_user_logged_in()){
  
    echo '<p>You need to be <a href="/wp-login.php">logged in</a> to view the gallery images.</p><br/><p>Not yet registred? <a href="/wp-login.php?action=register">Register here</a></p>';    

  }
  ?>
    
  </div><!-- .entry-content -->
  
</article><!-- #post-<?php the_ID(); ?> -->

<?php get_footer(); ?>