<?php
//--If Add Shortcode use any single page with design--//
function csaf_add_css_js(){        
    wp_enqueue_style( 'csaf_main', plugin_dir_url(__FILE__) . '../css/front/main.css', array(), '1.0.0', 'all' );  
    
    wp_enqueue_style( 'csaf_bootstrap', plugin_dir_url(__FILE__) . '../css/front/bootstrap.min.css', array(), '1.0.0', 'all' );   
    wp_enqueue_style( 'csaf_style', plugin_dir_url(__FILE__) . '../css/front/style.css', array(), '1.0.0', 'all' ); 
	  wp_enqueue_script('csaf_bootstrap_js', plugin_dir_url(__FILE__) . '../css/front/bootstrap.min.js' , array('jquery'),'1.0.0',true);   
    
    
}add_action('wp_enqueue_scripts','csaf_add_css_js');
function csaf_admin_enqueue($hook) {  
   if ( 'csection_page_appform' == $hook ) {  
    wp_enqueue_style('af-admin-css', plugin_dir_url( __FILE__ ). '../css/admin.css', array(), '1.0.0', 'all');
	  wp_enqueue_script('af_custom_js', plugin_dir_url(__FILE__) . '../js/custom.js' , array('jquery'),'1.0.0',true);   
    }
  }add_action('admin_enqueue_scripts', 'csaf_admin_enqueue');
?>
