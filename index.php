<?php
/*
 * Plugin Name: Career Section
 * Plugin URI: https://wordpress.org/plugins/career-section
 * Description: Install and send your CV.
 * Author: Md. Shahinur Islam
 * Author URI: https://profiles.wordpress.org/shahinurislam
 * Version: 1.5
 * Text Domain: csaf
 * Domain Path: /lang
 * Network: True
 * License: GPLv2
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */
 
define( 'CSAF_PLUGIN', __FILE__ );
define( 'CSAF_PLUGIN_DIR', untrailingslashit( dirname( CSAF_PLUGIN ) ) );
require_once CSAF_PLUGIN_DIR . '/include/posttype.php';
require_once CSAF_PLUGIN_DIR . '/include/enqueue.php';
require_once CSAF_PLUGIN_DIR . '/include/dashboard_widget.php';
require_once CSAF_PLUGIN_DIR . '/include/top_level_menu.php';
//-------------- Load Custom post type Single page --------------------//
function csection_single_template( $template ) {
    global $post;
    if ( 'csection' === $post->post_type) {
        return plugin_dir_path( __FILE__ ) . 'templates/single-csection.php';   
    } 
    return $template;
}
add_filter( 'single_template', 'csection_single_template' );

//db create------------------------------------
global $csaf_jal_db_version;
$csaf_jal_db_version = '1.0';
function csaf_jal_install() {
	global $wpdb;
	global $csaf_jal_db_version;
	
	$table_name = $wpdb->prefix . 'cs_applicant_submissions';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		first_name tinytext NOT NULL,		
		last_name tinytext NOT NULL,
		present_address text NOT NULL,
		email_address varchar(55) DEFAULT '' NOT NULL,
		mobile_no tinytext NOT NULL,
		post_name text NOT NULL,
		cv text NOT NULL,
		created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'csaf_jal_db_version', $csaf_jal_db_version );
}
register_activation_hook( __FILE__, 'csaf_jal_install' );
global $wpdb;
$installed_ver = get_option( "csaf_jal_db_version" );
if ( $installed_ver != $csaf_jal_db_version ) {

	$table_name = $wpdb->prefix . 'cs_applicant_submissions';

	$sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		first_name tinytext NOT NULL,		
		last_name tinytext NOT NULL,
		present_address text NOT NULL,
		email_address varchar(55) DEFAULT '' NOT NULL,
		mobile_no tinytext NOT NULL,
		post_name text NOT NULL,
		cv text NOT NULL,
		created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	update_option( "csaf_jal_db_version", $csaf_jal_db_version );
}
function csaf_update_db_check() {
    global $csaf_jal_db_version;
    if ( get_site_option( 'csaf_jal_db_version' ) != $csaf_jal_db_version ) {
        csaf_jal_install();
    }
}
add_action( 'plugins_loaded', 'csaf_update_db_check' );
//db create------------------------------------

//shortcode
function csaf_shortcode_wrapper($atts) {
ob_start();
?>

<!-- joblist--> 
             
<div class="container">
    <div class="section-content">
        <div class="twm-jobs-list-wrap">
            <ul>
            <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $csection_main_blog = new WP_Query(array(
                    'post_type'=>'csection',
                    'posts_per_page'=>3,
                    'paged' => $paged
                ));
                if($csection_main_blog->have_posts())	:	
                $count = 1;		
                while($csection_main_blog->have_posts())	: $csection_main_blog->the_post(); ?>

                <li>
                    <div class="twm-jobs-list-style1 mb-5">
                        <div class="twm-media"><img src="<?php esc_html_e(get_post_meta(get_the_ID(), 'cs_logo', true));?>" alt="Logo">
                        </div>
                        <div class="twm-mid-content">
                            <a href="<?php the_permalink();?>" class="twm-job-title">
                                <h4 class="headingh4"><?php the_title();?> <span class="twm-job-post-duration">/ <?php echo csaf_time_ago(); ?></span></h4>
                            </a>
                            <p class="twm-job-address"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_address', true));?></p>
                            <p class="twm-job-websites site-text-primary"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_experience', true));?> of experience.</p>
                        </div>
                        <div class="twm-right-content">
                            <div class="twm-jobs-category green"><span class="twm-bg-green"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_type', true));?></span></div>
                            <div class="twm-jobs-amount"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_salary', true));?> <span>/ Month</span></div>
                            <a href="<?php the_permalink();?>" class="twm-jobs-browse site-text-primary">Browse Job</a>
                        </div>
                    </div>
                </li>
			<?php endwhile; ?>		
	        <?php endif;?> 
            </ul>
            <!-- <div class="text-center m-b30">
                <a href="job-list.html" class=" site-button">Browse All Jobs</a>
            </div> -->
        </div>
    </div>    
</div> 
<?php   
 return ob_get_clean();
}
add_shortcode('cs_applicant_form','csaf_shortcode_wrapper'); 
//side setting link
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'csaf_plugin_action_links' );
function csaf_plugin_action_links( $actions ) {
   $actions[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=appform') ) .'">View Entries</a>';
   return $actions;
}
//time ago 
function csaf_time_ago( $type = 'csection' ) {
    $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
    return human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago');
}
//ad meta box
function csaf_matabox(){
    add_meta_box( 
    'name_meta',//id
    'Career Details',//title
    'csaf_meta_callback',//callback
    'csection',//screen
    'normal',//context
    'high'//priority
    );
   }
   
   add_action('add_meta_boxes','csaf_matabox');  
   
   function csaf_meta_callback($post){   
     $cs_logo = get_post_meta($post->ID,'cs_logo',true); 
     $cs_address = get_post_meta($post->ID,'cs_address',true); 
     $cs_type = get_post_meta($post->ID,'cs_type',true); 
     $cs_salary = get_post_meta($post->ID,'cs_salary',true); 
     $cs_experience = get_post_meta($post->ID,'cs_experience',true);  
     $cs_qualification = get_post_meta($post->ID,'cs_qualification',true); 
     $cs_gender = get_post_meta($post->ID,'cs_gender',true); 
     $cs_deadline = get_post_meta($post->ID,'cs_deadline',true); 
     wp_nonce_field('save_csaf_meta','name_nonce');   
    ?> 

    <p><label>Company Logo URL </label><input type="text" name="cs_logo" value="<?php esc_html_e($cs_logo,'csaf');?>" placeholder="link" /></p>  
    <p><label>Address </label><input type="text" name="cs_address" value="<?php esc_html_e($cs_address,'csaf');?>" placeholder="1363-1385 Sunset Blvd Los Angeles, CA 90026, USA" /></p> 
    <p><label>Type </label><input type="text" name="cs_type" value="<?php esc_html_e($cs_type,'csaf');?>" placeholder="New or Part Time or FUll Time" /></p> 
    <p><label>Salary per month </label><input type="text" name="cs_salary" value="<?php esc_html_e($cs_salary,'csaf');?>" placeholder="$2000" /></p> 
    <p><label>Experiencs </label><input type="text" name="cs_experience" value="<?php esc_html_e($cs_experience,'csaf');?>" placeholder="3 Years" /></p> 
    <p><label>Qualification </label><input type="text" name="cs_qualification" value="<?php esc_html_e($cs_qualification,'csaf');?>" placeholder="Bachelor Degree" /></p> 
    <p><label>Gender </label><input type="text" name="cs_gender" value="<?php esc_html_e($cs_gender,'csaf');?>" placeholder="Both" /></p> 
    <p><label>Application DeadLine </label><input type="text" name="cs_deadline" value="<?php esc_html_e($cs_deadline,'csaf');?>" placeholder="33-03-2023" /></p> 
   <?php   
   }  
   
   function save_csaf_meta($post_id){ 
    //Check if our nonce is set   
    if(! isset($_POST['name_nonce'])){   
     return;   
    }   
    //Check if our nonce is valid   
    if(! wp_verify_nonce($_POST['name_nonce'],'save_csaf_meta')){   
     return;   
    }   
    // Make sure that it(input) is set.   
    if(! isset($_POST['cs_address'])){   
     return;   
    }
    if(! isset($_POST['cs_type'])){   
        return;   
    }
    if(! isset($_POST['cs_salary'])){   
        return;   
    }
    if(! isset($_POST['cs_experience'])){   
        return;   
    }
    if(! isset($_POST['cs_qualification'])){   
        return;   
    }
    if(! isset($_POST['cs_gender'])){   
        return;   
    }
    if(! isset($_POST['cs_deadline'])){   
        return;   
    }
    if(! isset($_POST['cs_logo'])){   
        return;   
    }
   
    
    $my_cs_logo = sanitize_text_field($_POST['cs_logo']);  
    update_post_meta($post_id,'cs_logo',$my_cs_logo); 
    //sanitize text fields   
    $my_cs_address = sanitize_text_field($_POST['cs_address']);   
    //Update post meta   
    update_post_meta($post_id,'cs_address',$my_cs_address);       
    $my_cs_type = sanitize_text_field($_POST['cs_type']);  
    update_post_meta($post_id,'cs_type',$my_cs_type);  
    $my_cs_salary = sanitize_text_field($_POST['cs_salary']);  
    update_post_meta($post_id,'cs_salary',$my_cs_salary);  
    $my_cs_experience = sanitize_text_field($_POST['cs_experience']);  
    update_post_meta($post_id,'cs_experience',$my_cs_experience);  
    $my_cs_qualification = sanitize_text_field($_POST['cs_qualification']);  
    update_post_meta($post_id,'cs_qualification',$my_cs_qualification); 
    $my_cs_gender = sanitize_text_field($_POST['cs_gender']);  
    update_post_meta($post_id,'cs_gender',$my_cs_gender); 
    $my_cs_deadline = sanitize_text_field($_POST['cs_deadline']);  
    update_post_meta($post_id,'cs_deadline',$my_cs_deadline); 

   } 
   add_action('save_post','save_csaf_meta');
?>
