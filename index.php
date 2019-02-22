<?php 
/*
 Plugin Name: VW One Page Pro Posttype
 lugin URI: https://www.vwthemes.com/
 Description: Creating new post type for VW One Page Pro Theme.
 Author: VW Themes
 Version: 1.0
 Author URI: https://www.vwthemes.com/
*/

define( 'vw_one_page_pro_POSTTYPE_VERSION', '1.0' );
add_action( 'init', 'createcategory');
add_action( 'init', 'vw_one_page_pro_posttype_create_post_type' );

function vw_one_page_pro_posttype_create_post_type() {
  register_post_type( 'project',
    array(
      'labels' => array(
        'name' => __( 'Project','vw-one-page-pro-posttype' ),
        'singular_name' => __( 'Project','vw-one-page-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-portfolio',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'faq',
    array(
      'labels' => array(
        'name' => __( 'Faqs','vw-one-page-pro-posttype' ),
        'singular_name' => __( 'Faqs','vw-one-page-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-pressthis',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'testimonials',
    array(
  		'labels' => array(
  			'name' => __( 'Testimonials','vw-one-page-pro-posttype' ),
  			'singular_name' => __( 'Testimonials','vw-one-page-pro-posttype' )
  		),
  		'capability_type' => 'post',
  		'menu_icon'  => 'dashicons-businessman',
  		'public' => true,
  		'supports' => array(
  			'title',
  			'editor',
  			'thumbnail'
  		)
		)
	);
  register_post_type( 'team',
    array(
      'labels' => array(
        'name' => __( 'Our Team','vw-one-page-pro-posttype' ),
        'singular_name' => __( 'Our Team','vw-one-page-pro-posttype' )
      ),
        'capability_type' => 'post',
        'menu_icon'  => 'dashicons-groups',
        'public' => true,
        'supports' => array( 
          'title',
          'editor',
          'thumbnail'
      )
    )
  );
}

/*--------------- Project Category ----------------*/
function createcategory() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => __( 'Project Category', 'vw-one-page-pro-posttype' ),
    'singular_name'     => __( 'Project Category', 'vw-one-page-pro-posttype' ),
    'search_items'      => __( 'Search Ccats', 'vw-one-page-pro-posttype' ),
    'all_items'         => __( 'All Project Category', 'vw-one-page-pro-posttype' ),
    'parent_item'       => __( 'Parent Project Category', 'vw-one-page-pro-posttype' ),
    'parent_item_colon' => __( 'Parent Project Category:', 'vw-one-page-pro-posttype' ),
    'edit_item'         => __( 'Edit Project Category', 'vw-one-page-pro-posttype' ),
    'update_item'       => __( 'Update Project Category', 'vw-one-page-pro-posttype' ),
    'add_new_item'      => __( 'Add New Project Category', 'vw-one-page-pro-posttype' ),
    'new_item_name'     => __( 'New Project Category Name', 'vw-one-page-pro-posttype' ),
    'menu_name'         => __( 'Project Category', 'vw-one-page-pro-posttype' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'createcategory' ),
  );
  register_taxonomy( 'createcategory', array( 'project' ), $args );
}

/*----------------------Testimonial section ----------------------*/
/* Adds a meta box to the Testimonial editing screen */
function vw_one_page_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'vw-one-page-pro-posttype-testimonial-meta', __( 'Enter Details', 'vw-one-page-pro-posttype' ), 'vw_one_page_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'vw_one_page_pro_posttype_bn_testimonial_meta_box');
}
/* Adds a meta box for custom post */
function vw_one_page_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'vw_one_page_pro_posttype_posttype_testimonial_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  if(!empty($bn_stored_meta['vw_one_page_pro_posttype_testimonial_desigstory'][0]))
      $bn_vw_one_page_pro_posttype_testimonial_desigstory = $bn_stored_meta['vw_one_page_pro_posttype_testimonial_desigstory'][0];
    else
      $bn_vw_one_page_pro_posttype_testimonial_desigstory = '';
	?>
	<div id="testimonials_custom_stuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php _e( 'Designation', 'vw-one-page-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="vw_one_page_pro_posttype_testimonial_desigstory" id="vw_one_page_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $bn_vw_one_page_pro_posttype_testimonial_desigstory ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

/* Saves the custom meta input */
function vw_one_page_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['vw_one_page_pro_posttype_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['vw_one_page_pro_posttype_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save desig.
	if( isset( $_POST[ 'vw_one_page_pro_posttype_testimonial_desigstory' ] ) ) {
		update_post_meta( $post_id, 'vw_one_page_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'vw_one_page_pro_posttype_testimonial_desigstory']) );
	}
}

add_action( 'save_post', 'vw_one_page_pro_posttype_bn_metadesig_save' );

/*------------------------- Team Section -----------------------------*/
/* Adds a meta box for Designation */
function vw_one_page_pro_posttype_bn_team_meta() {
    add_meta_box( 'vw_one_page_pro_posttype_bn_meta', __( 'Enter Details','vw-one-page-pro-posttype' ), 'vw_one_page_pro_posttype_ex_bn_meta_callback', 'team', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'vw_one_page_pro_posttype_bn_team_meta');
}
/* Adds a meta box for custom post */
function vw_one_page_pro_posttype_ex_bn_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'vw_one_page_pro_posttype_bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );

    //Email details
    if(!empty($bn_stored_meta['meta-desig'][0]))
      $bn_meta_desig = $bn_stored_meta['meta-desig'][0];
    else
      $bn_meta_desig = '';

    //Phone details
    if(!empty($bn_stored_meta['meta-call'][0]))
      $bn_meta_call = $bn_stored_meta['meta-call'][0];
    else
      $bn_meta_call = '';

    //facebook details
    if(!empty($bn_stored_meta['meta-facebookurl'][0]))
      $bn_meta_facebookurl = $bn_stored_meta['meta-facebookurl'][0];
    else
      $bn_meta_facebookurl = '';

    //linkdenurl details
    if(!empty($bn_stored_meta['meta-linkdenurl'][0]))
      $bn_meta_linkdenurl = $bn_stored_meta['meta-linkdenurl'][0];
    else
      $bn_meta_linkdenurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-twitterurl'][0]))
      $bn_meta_twitterurl = $bn_stored_meta['meta-twitterurl'][0];
    else
      $bn_meta_twitterurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-googleplusurl'][0]))
      $bn_meta_googleplusurl = $bn_stored_meta['meta-googleplusurl'][0];
    else
      $bn_meta_googleplusurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-designation'][0]))
      $bn_meta_designation = $bn_stored_meta['meta-designation'][0];
    else
      $bn_meta_designation = '';

    ?>
    <div id="agent_custom_stuff">
        <table id="list-table">         
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-1">
                    <td class="left">
                        <?php esc_html_e( 'Email', 'vw-one-page-pro-posttype' )?>
                    </td>
                    <td class="left" >
                        <input type="text" name="meta-desig" id="meta-desig" value="<?php echo esc_attr($bn_meta_desig); ?>" />
                    </td>
                </tr>
                <tr id="meta-2">
                    <td class="left">
                        <?php esc_html_e( 'Phone Number', 'vw-one-page-pro-posttype' )?>
                    </td>
                    <td class="left" >
                        <input type="text" name="meta-call" id="meta-call" value="<?php echo esc_attr($bn_meta_call); ?>" />
                    </td>
                </tr>
                <tr id="meta-3">
                  <td class="left">
                    <?php esc_html_e( 'Facebook Url', 'vw-one-page-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-facebookurl" id="meta-facebookurl" value="<?php echo esc_url($bn_meta_facebookurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-4">
                  <td class="left">
                    <?php esc_html_e( 'Linkedin URL', 'vw-one-page-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-linkdenurl" id="meta-linkdenurl" value="<?php echo esc_url($bn_meta_linkdenurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-5">
                  <td class="left">
                    <?php esc_html_e( 'Twitter Url', 'vw-one-page-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-twitterurl" id="meta-twitterurl" value="<?php echo esc_url( $bn_meta_twitterurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-6">
                  <td class="left">
                    <?php esc_html_e( 'GooglePlus URL', 'vw-one-page-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-googleplusurl" id="meta-googleplusurl" value="<?php echo esc_url($bn_meta_googleplusurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-7">
                  <td class="left">
                    <?php esc_html_e( 'Designation', 'vw-one-page-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="text" name="meta-designation" id="meta-designation" value="<?php echo esc_attr($bn_meta_designation); ?>" />
                  </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}
/* Saves the custom Designation meta input */
function vw_one_page_pro_posttype_ex_bn_metadesig_save( $post_id ) {
    if( isset( $_POST[ 'meta-desig' ] ) ) {
        update_post_meta( $post_id, 'meta-desig', esc_html($_POST[ 'meta-desig' ]) );
    }
    if( isset( $_POST[ 'meta-call' ] ) ) {
        update_post_meta( $post_id, 'meta-call', esc_html($_POST[ 'meta-call' ]) );
    }
    // Save facebookurl
    if( isset( $_POST[ 'meta-facebookurl' ] ) ) {
        update_post_meta( $post_id, 'meta-facebookurl', esc_url($_POST[ 'meta-facebookurl' ]) );
    }
    // Save linkdenurl
    if( isset( $_POST[ 'meta-linkdenurl' ] ) ) {
        update_post_meta( $post_id, 'meta-linkdenurl', esc_url($_POST[ 'meta-linkdenurl' ]) );
    }
    if( isset( $_POST[ 'meta-twitterurl' ] ) ) {
        update_post_meta( $post_id, 'meta-twitterurl', esc_url($_POST[ 'meta-twitterurl' ]) );
    }
    // Save googleplusurl
    if( isset( $_POST[ 'meta-googleplusurl' ] ) ) {
        update_post_meta( $post_id, 'meta-googleplusurl', esc_url($_POST[ 'meta-googleplusurl' ]) );
    }
    // Save designation
    if( isset( $_POST[ 'meta-designation' ] ) ) {
        update_post_meta( $post_id, 'meta-designation', esc_html($_POST[ 'meta-designation' ]) );
    }
}
add_action( 'save_post', 'vw_one_page_pro_posttype_ex_bn_metadesig_save' );

add_action( 'save_post', 'bn_meta_save' );
/* Saves the custom meta input */
function bn_meta_save( $post_id ) {
  if( isset( $_POST[ 'vw_one_page_pro_posttype_team_featured' ] )) {
      update_post_meta( $post_id, 'vw_one_page_pro_posttype_team_featured', esc_attr(1));
  }else{
    update_post_meta( $post_id, 'vw_one_page_pro_posttype_team_featured', esc_attr(0));
  }
}

/*---------------- Project Shortcode ---------------------*/
function vw_one_page_pro_posttype_project_func( $atts ) {
    $project = ''; 
    $project = '<div id="our_work" class="row inner-test-bg">';
      $new = new WP_Query( array( 'post_type' => 'project') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'small' );
          $url = $thumb['0'];
          $project .= '<div class="col-md-3 col-sm-6 mt-4">
              <div class="box">';
                if (has_post_thumbnail()){
                  $project.= '<img src="'.esc_url($url).'">';
                  }
                $project.= '<div class="over-layer">
                  <div class="work_content">'; 
                    $project.= '
                    <h4 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>

                    <div class="box-search-icon"><a href="'.get_the_permalink().'"><i class="fas fa-long-arrow-alt-right"></i></a></div>
                  </div>
                </div>
              </div>
          </div>
          <div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $project.= '</div>';
      else :
        $project = '<div id="our_work" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','vw-one-page-pro-posttype').'</h2></div>';
      endif;
      $project.= '</div>';
    return $project;
}
add_shortcode( 'vw-one-page-pro-project', 'vw_one_page_pro_posttype_project_func' );

/*------------------- Faq Shortcode -------------------------*/
function vw_one_page_pro_posttype_faq_func( $atts ) {
    $faq = ''; 
    $faq = '<div id="faqs"><div class="row">';
      $new = new WP_Query( array( 'post_type' => 'faq') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $excerpt = vw_one_page_pro_string_limit_words(get_the_excerpt(),20);
          $faq .= '
          <div class="col-lg-4 col-md-4 mb-4">  
            <div class="faq-box"> 
              <h4><i class="fas fa-angle-double-right"></i> <a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
              <div class="faqs_content">'.$excerpt.'</div>
            </div>
          </div>
          <div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $faq = '<div id="faq" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','vw-one-page-pro-posttype').'</h2></div></div></div>';
      endif;
    $faq .= '</div></div>';
    return $faq;
}
add_shortcode( 'vw-one-page-pro-faq', 'vw_one_page_pro_posttype_faq_func' );

/*------------- Team Shortcode --------------*/
function vw_one_page_pro_posttype_team_func( $atts ) {
    $team = ''; 
    $team = '<div class="row" id="team">';
      $new = new WP_Query( array( 'post_type' => 'team') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $designation = get_post_meta($post_id,'meta-designation',true);
          $call = get_post_meta($post_id,'meta-call',true);
          $email = get_post_meta($post_id,'meta-desig',true);
          $facebookurl = get_post_meta($post_id,'meta-facebookurl',true);
          $linkedin = get_post_meta($post_id,'meta-linkdenurl',true);
          $twitter = get_post_meta($post_id,'meta-twitterurl',true);
          $googleplus = get_post_meta($post_id,'meta-googleplusurl',true);

          $team .= '
          <div class="col-md-3">
            <div class="teambox">';
              if (has_post_thumbnail()){
               $team .= '<img src="'.esc_url($url).'">
                <div class="teambox-content">
                  <h4 class="teamtitle"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>';
                  if($designation != ''){
                    $team .= '<p>'.esc_html($designation).'</p>';
                  }
                  $team .= '
                  <ul class="teamicon">';
                    if($facebookurl != '' || $linkedin != '' || $twitter != '' || $googleplus != ''){
                   $team .= '<li>';    
                       if($facebookurl != '')
                       {
                        $team .= '<a class="" href="'.esc_url($facebookurl).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                       } 
                    $team .= '</li><li>';   
                       if($twitter != '')
                       {
                        $team .= '<a class="" href="'.esc_url($twitter).'" target="_blank"><i class="fab fa-twitter"></i></a>';                          
                       }
                    $team .= '</li><li>';     
                       if($linkedin != '')
                       {
                       $team .= ' <a class="" href="'.esc_url($linkedin).'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
                       }
                    $team .= '</li><li>';   
                       if($googleplus != '')
                       {
                        $team .= '<a class="" href="'.esc_url($googleplus).'" target="_blank"><i class="fab fa-google-plus-g"></i></a>';
                       }
                    $team .= '</li>';    
                    }
                  $team .= '</ul>
                </div>';
              }
            $team .= '</div>
            </div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $team = '<div id="team" class="team_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','vw-one-page-pro-posttype').'</h2></div>';
      endif;
    $team .= '</div>';
    return $team;
}
add_shortcode( 'vw-one-page-pro-team', 'vw_one_page_pro_posttype_team_func' );

/*-------------- Testimonial Shortcode -----------------*/
function vw_one_page_pro_posttype_testimonials_func( $atts ) {
    $testimonial = ''; 
    $testimonial = '<div id="testimonials"><div class="row inner-test-bg">';
      $new = new WP_Query( array( 'post_type' => 'testimonials') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = vw_one_page_pro_string_limit_words(get_the_excerpt(),20);
          $designation = get_post_meta($post_id,'vw_one_page_pro_posttype_testimonial_desigstory',true);

          $testimonial .= '<div class="col-md-6 mb-4">
              <div class="testimonials_inner">
                <div class="testimonial_box col-md-10 offset-md-1" >
                  <div class="content_box w-100">
                    <div class="client_text pb-3"><blockquote>'.$excerpt.'</blockquote></div>
                  </div>                  
                </div>
                <ul class="testimonial_auther">
                  <li class="textimonial-img">';
                    if (has_post_thumbnail()){
                    $testimonial.= '<img src="'.esc_url($url).'">';
                    }
                  $testimonial .= '</li>
                  <li class="testimonial-box">
                    <h4 class="client_name"><a href="'.get_the_permalink().'">'.get_the_title().'</a> <cite>'.esc_html($designation).'</cite></h4>
                  </li>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $testimonial = '<div id="testimonial" class="testimonial_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','vw-one-page-pro-posttype').'</h2></div>';
      endif;
    $testimonial .= '</div></div>';
    return $testimonial;
}
add_shortcode( 'vw-one-page-pro-testimonials', 'vw_one_page_pro_posttype_testimonials_func' );

