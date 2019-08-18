<?php
/**
 * Plugin Name: PivotRoots Assignment
 * Plugin URI: http://pivotroots.local/
 * Description: This plugin enables a custom Registration Form and Gallery Management functionality, with a twist for Country specific viewing, as per the requirement provided.
 * Version: 0.1.0
 * Author: Gayatri Tanksali
 * Author URI: https://gayatri.life
 */

add_filter( 'login_redirect', function() { return site_url('upload-gallery'); } );

add_action( 'register_form', 'crf_registration_form' );
function crf_registration_form() {

	$full_name = ! empty( $_POST['full_name'] ) ? intval( $_POST['full_name'] ) : '';
	$mobile = ! empty( $_POST['mobile'] ) ? intval( $_POST['mobile'] ) : '';
	$city = ! empty( $_POST['city'] ) ? strval( $_POST['city'] ) : '';
	$country = ! empty( $_POST['country'] ) ? strval( $_POST['country'] ) : '';

	?>
	<p>
		<label for="mobile"><?php esc_html_e( 'Full Name', 'crf' ) ?><br/>
			<input type="text" id="full_name" name="full_name" value="<?php echo esc_attr( $full_name ); ?>" class="input" />
		</label>
	</p>
	<p>
		<label for="mobile"><?php esc_html_e( 'Mobile', 'crf' ) ?><br/>
			<input type="number" id="mobile" name="mobile" value="<?php echo esc_attr( $mobile ); ?>" class="input" />
		</label>
	</p>
	<p>
		<label for="city"><?php esc_html_e( 'City', 'crf' ) ?><br/>
			<input type="text" id="city" name="city" value="<?php echo esc_attr( $city ); ?>" class="input" />
		</label>
	</p>
	<p>
		<label for="country"><?php esc_html_e( 'Country', 'crf' ) ?><br/>
			<select class="country" id="country" name="country">
				<option value="India">India</option>
				<option value="USA">USA</option>
				<option value="Canada" selected>Canada</option>
			</select>
		</label>
	</p>
	<?php
}

add_filter( 'registration_errors', 'crf_registration_errors', 10, 3 );
function crf_registration_errors( $errors, $sanitized_user_login, $user_email ) {

	if ( empty( $_POST['full_name'] ) ) {
		$errors->add( 'full_name', __( '<strong>ERROR</strong>: Please enter your full name.', 'crf' ) );
	}

	if ( empty( $_POST['mobile'] ) ) {
		$errors->add( 'mobile', __( '<strong>ERROR</strong>: Please enter your Mobile.', 'crf' ) );
	}

	if ( empty( $_POST['city'] ) ) {
		$errors->add( 'city', __( '<strong>ERROR</strong>: Please enter your City.', 'crf' ) );
	}

	if ( empty( $_POST['country'] ) ) {
		$errors->add( 'country', __( '<strong>ERROR</strong>: Please enter your Country.', 'crf' ) );
	}

	return $errors;
}

add_action( 'user_register', 'crf_user_register' );
function crf_user_register( $user_id ) {
	if ( ! empty( $_POST['full_name'] ) ) {
		update_user_meta( $user_id, 'full_name', strval( $_POST['full_name'] ) );
	}
	if ( ! empty( $_POST['mobile'] ) ) {
		update_user_meta( $user_id, 'mobile', intval( $_POST['mobile'] ) );
	}
	if ( ! empty( $_POST['city'] ) ) {
		update_user_meta( $user_id, 'city', strval( $_POST['city'] ) );
	}
	if ( ! empty( $_POST['country'] ) ) {
		update_user_meta( $user_id, 'country', strval( $_POST['country'] ) );
	}
}

add_action( 'user_new_form', 'crf_admin_registration_form' );
function crf_admin_registration_form( $operation ) {
	if ( 'add-new-user' !== $operation ) {

		return;
	}

	$full_name = ! empty( $_POST['full_name'] ) ? intval( $_POST['full_name'] ) : '';
	$mobile = ! empty( $_POST['mobile'] ) ? intval( $_POST['mobile'] ) : '';
	$city = ! empty( $_POST['city'] ) ? strval( $_POST['city'] ) : '';
	$country = ! empty( $_POST['country'] ) ? strval( $_POST['country'] ) : '';

	?>
	<h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="full_name"><?php esc_html_e( 'Full Name', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
			<td>
				<input type="text" id="full_name" name="full_name" value="<?php echo esc_attr( $full_name ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="mobile"><?php esc_html_e( 'Mobile', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
			<td>
				<input type="text" id="mobile" name="mobile" value="<?php echo esc_attr( $mobile ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="city"><?php esc_html_e( 'City', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
			<td>
				<input type="text" id="city" name="city" value="<?php echo esc_attr( $city ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="country"><?php esc_html_e( 'country', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
			<td>
				<input type="text" id="country" name="country" value="<?php echo esc_attr( $country ); ?>" class="regular-text" />
			</td>
		</tr>
	</table>
	<?php
}

add_action( 'user_profile_update_errors', 'crf_user_profile_update_errors', 10, 3 );
function crf_user_profile_update_errors( $errors, $update, $user ) {
	if ( $update ) {
		return;
	}

	if ( empty( $_POST['full_name'] ) ) {
		$errors->add( 'full_name_error', __( '<strong>ERROR</strong>: Please enter your full name.', 'crf' ) );
	}

	if ( empty( $_POST['mobile'] ) ) {
		$errors->add( 'mobile_error', __( '<strong>ERROR</strong>: Please enter your Mobile.', 'crf' ) );
	}

	if ( empty( $_POST['city'] ) ) {
		$errors->add( 'city_error', __( '<strong>ERROR</strong>: Please enter your City.', 'crf' ) );
	}

	if ( empty( $_POST['country'] ) ) {
		$errors->add( 'country_error', __( '<strong>ERROR</strong>: Please enter your Country.', 'crf' ) );
	}

}

add_action( 'edit_user_created_user', 'crf_user_register' );

add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
	?>
	<h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="full_name"><?php esc_html_e( 'Full Name', 'crf' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'full_name', $user->ID ) ); ?></td>
		</tr>
		<tr>
			<th><label for="mobile"><?php esc_html_e( 'Mobile', 'crf' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'mobile', $user->ID ) ); ?></td>
		</tr>
		<tr>
			<th><label for="city"><?php esc_html_e( 'City', 'crf' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'city', $user->ID ) ); ?></td>
		</tr>
		<tr>
			<th><label for="country"><?php esc_html_e( 'Country', 'crf' ); ?></label></th>
			<td><?php echo esc_html( get_the_author_meta( 'country', $user->ID ) ); ?></td>
		</tr>
	</table>
	<?php
}

define('MAX_UPLOAD_SIZE', 200000);
define('TYPE_WHITELIST', serialize(array(
  'image/jpeg',
  'image/png',
  'image/gif'
  )));


add_shortcode('sui_form', 'sui_form_shortcode');


function sui_form_shortcode(){

  if(!is_user_logged_in()){

    return '<p>You need to be <a href="/wp-login.php">logged in</a> to submit an image.</p><br/><p>Not yet registered? <a href="/wp-login.php?action=register">Register here</a></p>';

  }

  global $current_user;

  if(isset( $_POST['sui_upload_image_form_submitted'] ) && wp_verify_nonce($_POST['sui_upload_image_form_submitted'], 'sui_upload_image_form') ){

    $result = sui_parse_file_errors($_FILES['sui_image_file'], $_POST['sui_image_caption']);

    if($result['error']){

      echo '<p>ERROR: ' . $result['error'] . '</p>';

    }else{

      $user_image_data = array(
      	'post_title' => $result['caption'],
        'post_status' => 'pending',
        'post_author' => $current_user->ID,
        'post_type' => 'user_images'
      );

      if($post_id = wp_insert_post($user_image_data)){

        sui_process_image('sui_image_file', $post_id, $result['caption']);

        wp_set_object_terms($post_id, (int)$_POST['sui_image_category'], 'sui_image_category');

      }
    }
  }

  if (isset( $_POST['sui_form_delete_submitted'] ) && wp_verify_nonce($_POST['sui_form_delete_submitted'], 'sui_form_delete')){

    if(isset($_POST['sui_image_delete_id'])){

      if($user_images_deleted = sui_delete_user_images($_POST['sui_image_delete_id'])){

        echo '<p>' . $user_images_deleted . ' images(s) deleted!</p>';

      }
    }
  }


  echo sui_get_upload_image_form($sui_image_caption = $_POST['sui_image_caption'], $sui_image_category = $_POST['sui_image_category']);

  if($user_images_table = sui_get_user_images_table($current_user->ID)){

    echo $user_images_table;

  }

}


function sui_delete_user_images($images_to_delete){

  $images_deleted = 0;

  foreach($images_to_delete as $user_image){

    if (isset($_POST['sui_image_delete_id_' . $user_image]) && wp_verify_nonce($_POST['sui_image_delete_id_' . $user_image], 'sui_image_delete_' . $user_image)){

      if($post_thumbnail_id = get_post_thumbnail_id($user_image)){

        wp_delete_attachment($post_thumbnail_id);

      }

      wp_trash_post($user_image);

      $images_deleted ++;

    }
  }

  return $images_deleted;

}


function sui_get_user_images_table($user_id){

  $args = array(
    'author' => $user_id,
    'post_type' => 'user_images',
    'post_status' => 'pending'
  );

  $user_images = new WP_Query($args);

  if(!$user_images->post_count) return 0;

  $out = '';
  $out .= '<p>Your unpublished images - Click to see full size</p>';

  $out .= '<form method="post" action="">';

  $out .= wp_nonce_field('sui_form_delete', 'sui_form_delete_submitted');

  $out .= '<table id="user_images">';
  $out .= '<thead><th>Image</th><th>Caption</th><th>Category</th><th>Delete</th></thead>';

  foreach($user_images->posts as $user_image){

    $user_image_cats = get_the_terms($user_image->ID, 'sui_image_category');

    foreach($user_image_cats as $cat){

      $user_image_cat = $cat->name;

    }

    $post_thumbnail_id = get_post_thumbnail_id($user_image->ID);

    $out .= wp_nonce_field('sui_image_delete_' . $user_image->ID, 'sui_image_delete_id_' . $user_image->ID, false);

    $out .= '<tr>';
    $out .= '<td>' . wp_get_attachment_link($post_thumbnail_id, 'thumbnail') . '</td>';
    $out .= '<td>' . $user_image->post_title . '</td>';
    $out .= '<td>' . $user_image_cat . '</td>';
    $out .= '<td><input type="checkbox" name="sui_image_delete_id[]" value="' . $user_image->ID . '" /></td>';
    $out .= '</tr>';

  }

  $out .= '</table>';

  $out .= '<input type="submit" name="sui_delete" value="Delete Selected Images" />';
  $out .= '</form>';

  return $out;

}


function sui_process_image($file, $post_id, $caption){

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attachment_id = media_handle_upload($file, $post_id);

  update_post_meta($post_id, '_thumbnail_id', $attachment_id);

  $attachment_data = array(
  	'ID' => $attachment_id,
    'post_excerpt' => $caption
  );

  wp_update_post($attachment_data);

  return $attachment_id;

}


function sui_parse_file_errors($file = '', $image_caption){

  $result = array();
  $result['error'] = 0;

  if($file['error']){

    $result['error'] = "No file uploaded or there was an upload error!";

    return $result;

  }

  $image_caption = trim(preg_replace('/[^a-zA-Z0-9\s]+/', ' ', $image_caption));

  if($image_caption == ''){

    $result['error'] = "Your caption may only contain letters, numbers and spaces!";

    return $result;

  }

  $result['caption'] = $image_caption;

  $image_data = getimagesize($file['tmp_name']);

  if(!in_array($image_data['mime'], unserialize(TYPE_WHITELIST))){

    $result['error'] = 'Your image must be a jpeg, png or gif!';

  }elseif(($file['size'] > MAX_UPLOAD_SIZE)){

    $result['error'] = 'Your image was ' . $file['size'] . ' bytes! It must not exceed ' . MAX_UPLOAD_SIZE . ' bytes.';

  }

  return $result;

}



function sui_get_upload_image_form($sui_image_caption = '', $sui_image_category = 0){

  $out = '';
  $out .= '<form id="sui_upload_image_form" method="post" action="" enctype="multipart/form-data">';
  $out .= wp_nonce_field('sui_upload_image_form', 'sui_upload_image_form_submitted');
  $out .= '<label for="sui_image_caption">Image Caption - Letters, Numbers and Spaces</label><br/>';
  $out .= '<input type="text" id="sui_image_caption" name="sui_image_caption" value="' . $sui_image_caption . '"/><br/>';
  //$out .= '<label for="sui_image_category">Image Category</label><br/>';
  //$out .= sui_get_image_categories_dropdown('sui_image_category', $sui_image_category) . '<br/>';
  $out .= '<label for="sui_image_file">Select Your Image - <span class="sui_note">(' . MAX_UPLOAD_SIZE . '  bytes maximum)</span></label><br/>';
  $out .= '<input type="file" size="60" name="sui_image_file" id="sui_image_file"><br/>';
  $out .= '<input type="submit" id="sui_submit" name="sui_submit" value="Upload Image">';

  $out .= '</form>';

  return $out;

}


function sui_get_image_categories_dropdown($taxonomy, $selected){

  return wp_dropdown_categories(array('taxonomy' => $taxonomy, 'name' => 'sui_image_category', 'selected' => $selected, 'hide_empty' => 0, 'echo' => 0));

}


add_action('init', 'sui_plugin_init');

function sui_plugin_init(){

  $image_type_labels = array(
    'name' => _x('User images', 'post type general name'),
    'singular_name' => _x('User Image', 'post type singular name'),
    'add_new' => _x('Add New User Image', 'image'),
    'add_new_item' => __('Add New User Image'),
    'edit_item' => __('Edit User Image'),
    'new_item' => __('Add New User Image'),
    'all_items' => __('View User Images'),
    'view_item' => __('View User Image'),
    'search_items' => __('Search User Images'),
    'not_found' =>  __('No User Images found'),
    'not_found_in_trash' => __('No User Images found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'User Images'
  );

  $image_type_args = array(
    'labels' => $image_type_labels,
    'public' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'map_meta_cap' => true,
    'menu_position' => null,
    'supports' => array('title', 'editor', 'author', 'thumbnail')
  );

  register_post_type('user_images', $image_type_args);

  $image_category_labels = array(
    'name' => _x( 'User Image Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'User Image', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search User Image Categories' ),
    'all_items' => __( 'All User Image Categories' ),
    'parent_item' => __( 'Parent User Image Category' ),
    'parent_item_colon' => __( 'Parent User Image Category:' ),
    'edit_item' => __( 'Edit User Image Category' ),
    'update_item' => __( 'Update User Image Category' ),
    'add_new_item' => __( 'Add New User Image Category' ),
    'new_item_name' => __( 'New User Image Name' ),
    'menu_name' => __( 'User Image Categories' ),
  );

  $image_category_args = array(
    'hierarchical' => true,
    'labels' => $image_category_labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'user_image_category' ),
  );

  register_taxonomy('sui_image_category', array('user_images'), $image_category_args);

  $default_image_cats = array('animals', 'people', 'landscape', 'people');

  foreach($default_image_cats as $cat){

    if(!term_exists($cat, 'sui_image_category')) wp_insert_term($cat, 'sui_image_category');

  }

}


?>