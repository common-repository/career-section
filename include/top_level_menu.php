<?php 
/**
 * Add the top level menu page.
 */
function csaf_options_page() {
	add_submenu_page(
		'edit.php?post_type=csection',
		'View Entries',
		'View Entries',
		'manage_options',
		'appform',
		'appform_options_page_html'
	);
}
/**
 * Register our wporg_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'csaf_options_page' );
/**
 * Top level menu callback function
 */
function appform_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	// check if the user have submitted the settings
	if ( isset( $_POST['delete_id'] ) ) {
	    //delete db raw
	    global $wpdb;
	    $table_name = $wpdb->prefix . "cs_applicant_submissions";
	    $wpdb->delete( $table_name, array( 'id' => sanitize_text_field($_POST['delete_id'] )) );
	    //delete files
	    global $wp_filesystem;
	    WP_Filesystem();
	    $content_directory = $wp_filesystem->wp_content_dir() . 'uploads/';
	    $target_dir_location = $content_directory . 'cs_applicant_submission_files/';
	    $file_path = $target_dir_location.sanitize_text_field($_POST['delete_file']);  // path of the file which need to be deleted.
        wp_delete_file( $file_path ); //delete file here.
	    
		// add settings saved message with the class of "updated"
		add_settings_error( 'af_messages', 'af_messages', __( 'Application permanently deleted.', 'csaf' ), 'updated' );
	}
	// show error/update messages
	settings_errors( 'af_messages' );
	?>
    <div class="wrap">
	<h1><?php esc_html_e( get_admin_page_title(),'csaf' ); ?></h1>
	<div class="shortcodeClass"> 
		<h2 class="email_recipint">Applications form shortcode:  
        	<span class="input">
        		<input type="text" id="afInput" value="<?php esc_html_e( '[cs_applicant_form]', 'csaf' );?>" readonly>
        	</span>
        	<div class="tooltip-af">
            	<button onclick="afTooltipFunction()" onmouseout="afoutFunc()" class="button-ffu">
            	  <span class="tooltiptext" id="afTooltip">Copy to clipboard</span>
            	  Click to Copy
            	  </button>
            </div>
        </h2>
        <form method="post" action="options.php">
        	<?php wp_nonce_field('update-options') ?>
        	<h3><strong><?php esc_html_e( 'Please add email for receive all application: ', 'csaf' );?></strong>
        	   <span class="input">
        	        <input type="text" name="email_recipint" size="45" value="<?php echo esc_html(get_option('email_recipint')); ?>" placeholder="<?php esc_html_e( 'youremail@gmail.com, email@email.com', 'csaf' );?>" />
        	   </span>
			   <button class="button-ffu submit_btn" type="submit">Save Settings</button>
        	         	        
                	<input type="hidden" name="action" value="update" />
                	<input type="hidden" name="page_options" value="email_recipint" />
        	    
        	</h3>
        	<!-- partial --> 
        </form>
    </div>
    <div class="add-filter-af">
        <div class="af-sortbyNumber">
            <select class="form-control-af" name="state" id="maxRows">
        		 <option value="5000">Show ALL Rows</option>
        		 <option value="5">5</option>
        		 <option value="10">10</option>
        		 <option value="15">15</option>
        		 <option value="20">20</option>
        		 <option value="50">50</option>
        		 <option value="70">70</option>
        		 <option value="100">100</option>
        	</select>
        </div>
        <div class="af-sortbySearch">
            <input id="afInputsearch" type="text" placeholder="Search..">
        </div>
    </div>

	<table id="paleBlueRows" class="paleBlueRows">
	  <thead>
	  <tr>
		<th>SL.</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Present Address</th>
		<th>Email Address</th>
		<th>Mobile No</th>
		<th>Post Name</th>
		<th>CV</th>
		<th style="cursor: pointer;">Date ↑↓</th>
		<th>Action</th> 
	  </tr>
	  </thead>
	  <tbody id="afmyTable">
	  <?php 
	  global $wpdb;
	  $table_name = $wpdb->prefix . "cs_applicant_submissions";
	  $user = $wpdb->get_results( "SELECT * FROM $table_name" );
	  $i = 0;
	  foreach ($user as $row){ 
	   ?>
	   <tr>
		<td><?php esc_html_e($i+=1,'csaf');?></td>
		<td><?php esc_html_e($row->first_name,'csaf');?></td>
		<td><?php esc_html_e($row->last_name,'csaf');?></td>
		<td><?php esc_html_e($row->present_address,'csaf');?></td>
		<td><?php esc_html_e($row->email_address,'csaf');?></td>
		<td><?php esc_html_e($row->mobile_no,'csaf');?></td>
		<td><?php esc_html_e($row->post_name,'csaf');?></td>
		<td>
			<?php if($row->cv != '' || $row->cv != null){ ?>
			<a href="<?php $upload_dir = wp_upload_dir(); echo esc_url($upload_dir['baseurl']).'/cs_applicant_submission_files/'.$row->cv;?>" target="_blank">Download CV
			</a>
			<?php }else{
		   	echo 'No CV Found';
	   		} ?>
		</td>
		<td><?php echo $row->created_date; ?></td>
		<td>
    	    <form class='form' action='' method='POST'>
    		    <input type="hidden" name="delete_file" value="<?php esc_html_e($row->cv,'csaf') ?>">
    		    <input type="hidden" name="delete_id" value="<?php esc_html_e($row->id,'csaf') ?>">
    		    <button class="button-ffu" type="submit" value="Delete">Delete</button>
    	    </form>
		</td>
	  </tr>  
	  <?php 
	  }
    if(empty($user) || !isset($user)){
        echo '<tr class="odd"><td colspan="10" style="text-align: center">No data available in table</td></tr>';
    }
	 ?>  
	  
	  </tbody>
	</table>
	<!--Start Pagination-->
	<div class='pagination-container' >
		<nav class="navClass">
			<ul class="pagination pagination-af">

			<li data-page="prev" >
			 <span> < <span class="sr-only">(current)</span></span>
			</li>
			<!--	Here the JS Function Will Add the Rows -->
			<li data-page="next" id="prev">
			   <span> > <span class="sr-only">(current)</span></span>
			</li>
			</ul>
		</nav>
	</div>
	
</div>
<?php
}
?>