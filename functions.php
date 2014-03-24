<?php

/**
 * Folio functions and definitions
 * copyright 2014, Utility Creative Services Inc.
 *
 * Note:  	This code will change quite a bit before it settles into form.  If you are
 * 			a developer looking to make customizations please use a child theme.
 * 			
 *
 * @package 	WordPress
 * @subpackage 	Folio
 * @since 		Folio 0.1.1
 */



/* ========================================================================================================================

Required external files

======================================================================================================================== */
if ( !defined( 'UTL_THEME_NAME' ) )
  define( 'UTL_THEME_NAME', 'measure' );

if ( !defined( 'UTL_THEME_VERSION' ) )
  define( 'UTL_THEME_VERSION', '0.1.1' );

if ( !defined( 'UTL_THEME_VERSION_HASH' ) )
  define( 'UTL_THEME_VERSION_HASH', '29348555' );   // set this anytime its updated and needs to force activation

if ( !defined( 'UTL_THEME_PATH' ) )
  define( 'UTL_THEME_PATH', get_template_directory().'/' );
  
if ( !defined( 'UTL_THEME_URL' ) )
  define( 'UTL_THEME_URL', get_template_directory_uri().'/' );

if ( !defined( 'UTL_ADMIN_PATH' ) )
	define( 'UTL_ADMIN_PATH', get_template_directory().'/lib/utl-admin/' );
	
if ( !defined( 'UTL_ADMIN_URL' ) )
	define( 'UTL_ADMIN_URL', get_template_directory_uri().'/lib/utl-admin/' );

if ( !defined( 'SCPT_PLUGIN_URL' ) )
  define( 'SCPT_PLUGIN_URL', get_template_directory_uri() . '/lib/super-cpt/' );

// require_once( 'lib/json-api/json-api.php' );
// require_once( 'lib/super-cpt/super-cpt.php' );
// require_once( 'lib/utl-admin/utl-admin.php' );
// require_once( 'lib/utl-admin/update.php' );

require_once( 'external/theme-utilities.php' );
// require_once( 'generator/generator-custom.post.php' );

// require_once( 'update.php' );


add_theme_support( 'post-thumbnails' );

update_option('image_default_align', 'center' );
update_option('image_default_link_type', 'media' );
update_option('image_default_size', 'large' );


/* ========================================================================================================================

Actions and Filters

======================================================================================================================== */




// SHOW FEATURED IMAGE IN LISTINGS




// # ADD NEW THUMBNAIL IMAGE SIZE
// -- Normal -- 
add_image_size( 'normal_thumb', 320, 9999 ); //320 pixels wide (and unlimited height)
// -- Retina -- 
add_image_size( 'retina_thumb', 640, 9999 );
// set jpeg image quality to 90
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );


add_filter( 'body_class', array( 'Theme_Utilities','add_slug_to_body_class' ) );



add_theme_support('menus');





/* ========================================================================================================================

Custom Settings Page

======================================================================================================================== */
add_action( 'init', 'utl_settings' ); 
add_action( 'admin_init', 'utl_settings_admin' ); 
add_action( 'admin_menu', 'utl_options_page');


function utl_settings() {


  // Settings Default
  add_option( 'UTL_color_background', '#ffffff'); 
  add_option( 'UTL_color_primary', '#000000'); 

  add_option( 'UTL_home_title', 'KNOW<br>THIS SH!T'); 
  add_option( 'UTL_home_label', 'You know the fundamentals of design, but have you brushed up on your business fundamentals? Helpful tips & tricks to put you in total control of your financial freedom.');

  add_option( 'UTL_stage_UD_title', 'Stage 1 - Design Utopia'); 
  add_option( 'UTL_stage_UD_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...');

  add_option( 'UTL_stage_BD_title', 'Stage 2 - Business Design'); 
  add_option( 'UTL_stage_BD_label', 'Eu tincidunt delicatissimi ius, eu mea facer veniam. Mea ad postea ocurreret complectitur, volumus moderatius ad pri...');

  add_option( 'UTL_stage_FM_title', 'Stage 3 - Financial Model'); 
  add_option( 'UTL_stage_FM_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...');

  add_option( 'UTL_stage_SE_title', 'Stage 4 - Strategy Execution'); 
  add_option( 'UTL_stage_SE_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...');

  add_option( 'UTL_stage_C_title', 'Calibrate'); 
  add_option( 'UTL_stage_C_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...');

  add_option( 'UTL_stage_P_title', 'Stage 5 - Positioning'); 
  add_option( 'UTL_stage_P_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...');

  add_option( 'UTL_stage_O_title', 'Stage 5 - Operations'); 
  add_option( 'UTL_stage_O_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...');

  add_option( 'UTL_stage_F_title', 'Stage 5 - Financial'); 
  add_option( 'UTL_stage_F_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...');

  add_option( 'UTL_stage_U_title', 'Stage 6 - Utopia'); 
  add_option( 'UTL_stage_U_label', 'Lorem ipsum dolor sit amet, an mel vidit tantas, cu eos iusto ...'); 


  // set the thumbnail sizes how we want
  update_option('thumbnail_size_w', 300);
  update_option('thumbnail_size_h', 300);
  update_option('medium_size_w', 640);
  update_option('medium_size_h', 1280);
  update_option('large_size_w', 1024);
  update_option('large_size_h', 2048);
}
  

function utl_settings_admin() {


  // draw the exposed settings
  register_setting( 'general', 'UTL_color_background', 'esc_html' ); 
  register_setting( 'general', 'UTL_color_primary', 'esc_html' );

  register_setting( 'utl-options', 'UTL_home_title' );
  register_setting( 'utl-options', 'UTL_home_label' );

  register_setting( 'utl-options', 'UTL_stage_UD_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_UD_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_BD_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_BD_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_FM_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_FM_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_SE_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_SE_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_C_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_C_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_P_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_P_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_O_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_O_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_F_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_F_label', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_U_title', 'esc_html' );
  register_setting( 'utl-options', 'UTL_stage_U_label', 'esc_html' );
        
}


/* add the settings page */
function utl_options_page() {
  add_options_page('KTS Settings', 'KTS Settings', 'manage_options', 'utl-options', 'render_options_page');
}









/* ==================================
      Custom post types

        -- fields provided by custom field suite
*/

function custom_post_workshop() {
  $labels = array(
    'name'               => __( 'Workshops' ),
    'singular_name'      => __( 'Workshop' ),
    'add_new'            => __( 'Add New' ),
    'add_new_item'       => __( 'Add New Workshop' ),
    'edit_item'          => __( 'Edit Workshop' ),
    'new_item'           => __( 'New Workshop' ),
    'all_items'          => __( 'All Workshops' ),
    'view_item'          => __( 'View Workshop' ),
    'search_items'       => __( 'Search Workshops' ),
    'not_found'          => __( 'No workshops found' ),
    'not_found_in_trash' => __( 'No workshops found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Workshops'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds details for a specific workshop',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'workshop', $args ); 
}
add_action( 'init', 'custom_post_workshop' );


// function custom_post_client() {
//   $labels = array(
//     'name'               => __( 'Clients' ),
//     'singular_name'      => __( 'Client' ),
//     'add_new'            => __( 'Add New' ),
//     'add_new_item'       => __( 'Add New Client' ),
//     'edit_item'          => __( 'Edit Client' ),
//     'new_item'           => __( 'New Client' ),
//     'all_items'          => __( 'All Clients' ),
//     'view_item'          => __( 'View Client' ),
//     'search_items'       => __( 'Search Clients' ),
//     'not_found'          => __( 'No workshops found' ),
//     'not_found_in_trash' => __( 'No workshops found in the Trash' ), 
//     'parent_item_colon'  => '',
//     'menu_name'          => 'Clients'
//   );
//   $args = array(
//     'labels'        => $labels,
//     'description'   => 'Holds details for a specific client',
//     'public'        => true,
//     'menu_position' => 5,
//     'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
//     'has_archive'   => true,
//   );
//   register_post_type( 'client', $args ); 
// }
// add_action( 'init', 'custom_post_client' );



function register_menus() {
  register_nav_menus(
    array(
      'kts-menu' => __( 'KTS Menu' ),
      'featured-articles' => __( 'Featured Articles' )
    )
  );
}
add_action( 'init', 'register_menus' );







/*  Render the options page */
function render_options_page() {
  ?>
<div class="wrap">
  <?php screen_icon(); ?>
  <h2>KTS Site Options</h2>
  <form method="post" action="options.php" id="utl-options"> 
    <?php settings_fields( 'utl-options' ); ?>

    <h3>Home Page Text</h3>
      <p>Customize the text for the homepage.</p>
      <table class="form-table">

        <tr valign="top">
          <th scope="row"><label for="UTL_home_title">Home Page Title</label></th>
          <td><input type="text" id="UTL_home_title" name="UTL_home_title" 
            value="<?php echo get_option('UTL_home_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_home_label">Home Page Text</label></th>
          <td><textarea type="text" id="UTL_home_label" name="UTL_home_label" 
              class="large-text"><?php echo get_option('UTL_home_label'); ?></textarea></td>
        </tr>


      </table>


    <h3>KTS Infographic Labels</h3>
      <p>Customize the text for the KTS infographic.</p>
      <table class="form-table">


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_UD_title">Design Utopia</label></th>
          <td><input type="text" id="UTL_stage_UD_title" name="UTL_stage_UD_title" 
            value="<?php echo get_option('UTL_stage_UD_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_UD_label"></label></th>
          <td><textarea type="text" id="UTL_stage_UD_label" name="UTL_stage_UD_label" 
              class="large-text"><?php echo get_option('UTL_stage_UD_label'); ?></textarea></td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_BD_title">Business Design</label></th>
          <td><input type="text" id="UTL_stage_BD_title" name="UTL_stage_BD_title" 
            value="<?php echo get_option('UTL_stage_BD_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_BD_label"></label></th>
          <td><textarea type="text" id="UTL_stage_BD_label" name="UTL_stage_BD_label" 
              class="large-text"><?php echo get_option('UTL_stage_BD_label'); ?></textarea></td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_FM_title">Financial Model</label></th>
          <td><input type="text" id="UTL_stage_FM_title" name="UTL_stage_FM_title" 
            value="<?php echo get_option('UTL_stage_FM_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_FM_label"></label></th>
          <td><textarea type="text" id="UTL_stage_FM_label" name="UTL_stage_FM_label" 
              class="large-text"><?php echo get_option('UTL_stage_FM_label'); ?></textarea></td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_SE_title">Strategy Execution</label></th>
          <td><input type="text" id="UTL_stage_SE_title" name="UTL_stage_SE_title" 
            value="<?php echo get_option('UTL_stage_SE_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_SE_label"></label></th>
          <td><textarea type="text" id="UTL_stage_SE_label" name="UTL_stage_SE_label" 
              class="large-text"><?php echo get_option('UTL_stage_SE_label'); ?></textarea></td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_C_title">Calibrate</label></th>
          <td><input type="text" id="UTL_stage_C_title" name="UTL_stage_C_title" 
            value="<?php echo get_option('UTL_stage_C_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_C_label"></label></th>
          <td><textarea type="text" id="UTL_stage_C_label" name="UTL_stage_C_label" 
              class="large-text"><?php echo get_option('UTL_stage_C_label'); ?></textarea></td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_P_title">Positioning</label></th>
          <td><input type="text" id="UTL_stage_P_title" name="UTL_stage_P_title" 
            value="<?php echo get_option('UTL_stage_P_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_P_label"></label></th>
          <td><textarea type="text" id="UTL_stage_P_label" name="UTL_stage_P_label" 
              class="large-text"><?php echo get_option('UTL_stage_P_label'); ?></textarea></td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_O_title">Operations</label></th>
          <td><input type="text" id="UTL_stage_O_title" name="UTL_stage_O_title" 
            value="<?php echo get_option('UTL_stage_O_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_O_label"></label></th>
          <td><textarea type="text" id="UTL_stage_O_label" name="UTL_stage_O_label" 
              class="large-text"><?php echo get_option('UTL_stage_O_label'); ?></textarea></td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="UTL_stage_F_title">Financial</label></th>
          <td><input type="text" id="UTL_stage_F_title" name="UTL_stage_F_title" 
            value="<?php echo get_option('UTL_stage_F_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_F_label"></label></th>
          <td><textarea type="text" id="UTL_stage_F_label" name="UTL_stage_F_label" 
              class="large-text"><?php echo get_option('UTL_stage_F_label'); ?></textarea></td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="UTL_stage_U_title">Utopia</label></th>
          <td><input type="text" id="UTL_stage_U_title" name="UTL_stage_U_title" 
            value="<?php echo get_option('UTL_stage_U_title'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="UTL_stage_U_label"></label></th>
          <td><textarea type="text" id="UTL_stage_U_label" name="UTL_stage_U_label" 
              class="large-text"><?php echo get_option('UTL_stage_U_label'); ?></textarea></td>
        </tr>


      </table>


    <?php submit_button(); ?>
  </form>
</div>
<?php
}
?>
