<?php
//Dashboard Widget
add_action('wp_dashboard_setup', 'csaf_custom_dashboard_widgets');
function csaf_custom_dashboard_widgets() {
global $wp_meta_boxes;
wp_add_dashboard_widget('custom_help_widget', 'CS Application Submission Lists', 'csaf_custom_dashboard_help');
}
function csaf_custom_dashboard_help() {
    ?>
    <style>
    .widgetClass{font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}
    .widgetClass td, th { border: 1px solid #dddddd;text-align: left;padding: 8px;}
    </style>
    <table class="widgetClass">
	  <thead>
	  <tr>
		<th>SL.</th>
		<th>First Name</th>
		<th>Email Address</th>
		<th>CV</th>
	  </tr>
	  </thead>
	  <tbody>
	  <?php 
	  global $wpdb;
	  $table_name = $wpdb->prefix . "cs_applicant_submissions";
	  $user = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY ID DESC LIMIT 5" );
	  $i = 0;
	  foreach ($user as $row){ 
	   ?>
	   <tr>
		<td><?php esc_html_e($i+=1,'csaf'); ?></td>
		<td><?php esc_html_e($row->first_name,'csaf'); ?></td> 
		<td><?php esc_html_e($row->email_address,'csaf'); ?></td> 
		<td>
			<?php if($row->cv != '' || $row->cv != null){ ?>
			<a href="<?php $upload_dir = wp_upload_dir(); echo esc_url($upload_dir['baseurl']).'/cs_applicant_submission_files/'.$row->cv;?>" target="_blank">Download CV
			</a>
			<?php }else{
		   	echo 'No CV Found';
	   		} ?>
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
    <?php
}
?>