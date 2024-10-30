<?php get_header();	

	while(have_posts())	: the_post();
?>
<!-- Job Detail V.2 START -->
<div class="section-full  p-t50 p-b90 bg-white">
	<div class="container">
	
		<!-- BLOG SECTION START -->
		<div class="section-content">
			<div class="twm-job-self-wrap twm-job-detail-v2">
				<div class="twm-job-self-info">
					<div class="twm-job-self-top">
						<div class="twm-media-bg">
							<?php if(has_post_thumbnail()) the_post_thumbnail();?>
							<div class="twm-jobs-category green"><span class="twm-bg-green"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_type', true),'csaf');?></span></div>
							<div class="twm-job-self-bottom">
								<a class="site-button" data-bs-toggle="modal" href="#apply_job_popup" role="button">
									Apply Now
								</a>
							</div>

						</div>
						
						<div class="twm-mid-content">

							<div class="twm-media">
								<img src="<?php esc_html_e(get_post_meta(get_the_ID(), 'cs_logo', true));?>" alt="Logo">
							</div>

							<h4 class="twm-job-title headingh4"><?php the_title();?> <span class="twm-job-post-duration">/ <?php echo csaf_time_ago(); ?></span></h4>
							<p class="twm-job-address"><i class="feather-map-pin"></i><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_address', true));?></p>
							<div class="twm-job-self-mid">
								<div class="twm-job-self-mid-left">
									<p class="twm-job-websites site-text-primary"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_experience', true));?> of experience.</p>
									<div class="twm-jobs-amount"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_salary', true));?> <span>/ Month</span></div>
								</div>
								<div class="twm-job-apllication-area">Application ends:
									<span class="twm-job-apllication-date"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_deadline', true));?></span>
								</div>
							</div>

							
						</div>
					</div>
					
				</div>
			</div>
			<div class="twm-job-detail-2-wrap">
				<div class="row d-flex justify-content-center">
					<div class="col-lg-4 col-md-12 rightSidebar">

						<div class="side-bar mb-4">
							<div class="twm-s-info2-wrap mb-5">
								<div class="twm-s-info2">
									<h4 class="section-head-small mb-4 headingh4">Job Information</h4>
									<ul class="twm-job-hilites2">

										<li>
											<div class="twm-s-info-inner">
												<i class="fas fa-calendar-alt"></i>
												<span class="twm-title">Date Posted</span>
												<div class="twm-s-info-discription"><?php esc_html_e(get_the_date( 'M d, Y' ));?></div>
											</div>
										</li>
										<li>
											<div class="twm-s-info-inner">
												<i class="fas fa-map-marker-alt"></i>
												<span class="twm-title">Location</span>
												<div class="twm-s-info-discription"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_address', true));?></div>
											</div>
										</li>
										<li>
											<div class="twm-s-info-inner">
												<i class="fas fa-user-tie"></i>
												<span class="twm-title">Job Title</span>
												<div class="twm-s-info-discription"><?php the_title();?></div>
											</div>
										</li>
										<li>
											<div class="twm-s-info-inner">
												<i class="fas fa-clock"></i>
												<span class="twm-title">Experience</span>
												<div class="twm-s-info-discription"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_experience', true));?></div>
											</div>
										</li>
										<li>
											<div class="twm-s-info-inner">
												<i class="fas fa-suitcase"></i>
												<span class="twm-title">Qualification</span>
												<div class="twm-s-info-discription"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_qualification', true));?></div>
											</div>
										</li>
										<li>
											<div class="twm-s-info-inner">
												<i class="fas fa-venus-mars"></i>
												<span class="twm-title">Gender</span>
												<div class="twm-s-info-discription"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_gender', true));?></div>
											</div>
										</li>
										<li>
											<div class="twm-s-info-inner">												
												<i class="fas fa-money-bill-wave"></i>
												<span class="twm-title">Offered Salary</span>
												<div class="twm-s-info-discription"><?php esc_html_e(get_post_meta(get_the_ID(), 'cs_salary', true));?> / Month</div>
											</div>
										</li>

									</ul>
									
								</div>
							</div>

							<div class="widget tw-sidebar-tags-wrap">
							<!-- tag baki decoration non dite hobe  -->
								<h4 class="section-head-small mb-4 headingh4">Job Skills</h4>
								<?php echo the_terms( get_the_ID(), 'cs_tag','<div class="tagcloud">','','</div>');  ?>
							</div>
						</div> 
					</div>				
					<div class="col-lg-8 col-md-12">
						<!-- Candidate detail START -->
						<div class="cabdidate-de-info">
							<?php the_content()?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>   
<!-- Job Detail V.2 END -->

<!-- insert data  -->
<?php 
if ( isset( $_POST['first_name'] ) ){
    
require_once(ABSPATH . 'wp-admin/includes/file.php');
global $wp_filesystem;
WP_Filesystem();
$content_directory = $wp_filesystem->wp_content_dir() . 'uploads/';
$wp_filesystem->mkdir( $content_directory . 'cs_applicant_submission_files' );
$target_dir_location = $content_directory . 'cs_applicant_submission_files/';	
$name_file = sanitize_text_field($_FILES['cv']['name']);
$name_file = time().'_'.$name_file;
$tmp_name = sanitize_text_field($_FILES['cv']['tmp_name']); 
if( move_uploaded_file( $tmp_name, $target_dir_location.$name_file ) ) {
	$cvfiles = "with your cv.";
} else {
	$cvfiles = "without your cv.";
}

// 	for email reciepnt
$email_reciepnt_message = '<p>Attachments: <b><a href="'.wp_upload_dir()['baseurl'].'/cs_applicant_submission_files/'.sanitize_text_field($name_file).'">Download</a><b></p>';
    
// if files not found 
if($_FILES['cv']['name'] == '' || $_FILES['cv']['name'] == null){
	$name_file = '';
    // 	for email reciepnt
    $email_reciepnt_message = '<p>Attachments: No File Attached.</p>';
}

global $wpdb;
$table_name = $wpdb->prefix."cs_applicant_submissions";
$sql = $wpdb->prepare( "INSERT INTO ".$table_name." (first_name, last_name, present_address, email_address, mobile_no, post_name, cv ) VALUES ( %s, %s, %s, %s, %s, %s, %s )", sanitize_text_field($_POST['first_name']), sanitize_text_field($_POST['last_name']), sanitize_text_field($_POST['present_address']), sanitize_text_field($_POST['email_address']), sanitize_text_field($_POST['mobile_no']), sanitize_text_field($_POST['post_name']), sanitize_text_field($name_file) );
$wpdb->query($sql);
// get the inserted record id.
$id = $wpdb->insert_id;
if($id>0){
	?>
		<div id="snackbar" class="rounded">Application has been sent <?php esc_html_e($cvfiles);?></div>
		<script> 
			var x = document.getElementById("snackbar");
			x.className = "show";
			setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		</script>		
	 
	<?php
	function csaf_sender_name( $original_email_from ) {
		return 'Application Form';
	}
	add_filter( 'wp_mail_from_name', 'csaf_sender_name' );
	//user notification
	$to = sanitize_email($_POST['email_address']);
	$subject = 'Thanks for application';
	$body = 'Dear, Thanks for application. We will contact soon.';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $to, $subject, $body, $headers );
	
	if(!empty(esc_html(get_option('email_recipint'))) || esc_html(get_option('email_recipint')) !== null){
    	//Email Receipint notification
    	$to = esc_html(get_option('email_recipint'));
    	$subject = 'Application For '.sanitize_text_field($_POST['post_name']);
    	$message = '<html><body>';
        $message .= '<h1>'.esc_html(get_bloginfo("name")).' Career Application</h1>';
        $message .= '<p>First Name: <b>'.sanitize_text_field($_POST['first_name']).'<b></p>';
        $message .= '<p>Last Name: <b>'.sanitize_text_field($_POST['last_name']).'<b></p>';
        $message .= '<p>Present Address: <b>'.sanitize_text_field($_POST['present_address']).'<b></p>';
        $message .= '<p>Email: <b>'.sanitize_text_field($_POST['email_address']).'<b></p>';
        $message .= '<p>Mobile: <b>'.sanitize_text_field($_POST['mobile_no']).'<b></p>';
        $message .= '<p>Post Name: <b>'.sanitize_text_field($_POST['post_name']).'<b></p>';
        $message .= $email_reciepnt_message;
        $message .= '</body></html>';
    	$body = $message;
    	$headers = array('Content-Type: text/html; charset=UTF-8');
    	wp_mail( $to, $subject, $body, $headers );
	}
	
}else{
	?>
	<div id="snackbar" class="rounded">Application not sent <?php esc_html_e($cvfiles);?></div>
		<script> 
			var x = document.getElementById("snackbar");
			x.className = "show";
			setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		</script> 	
<?php
}
}
?>
<!-- end insert data  -->

<!--apply job popup -->
<div class="modal fade" id="apply_job_popup" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">                    
				<div class="modal-header">
					<p class="modal-title" id="sign_up_popupLabel">Apply For This Job</p>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>                    
			<div class="modal-body">
				<div class="apl-job-inpopup">
					<!--Basic Information-->
					<div class="panel panel-default">						
						<div class="panel-body wt-panel-body p-a20 ">
							<div class="twm-tabs-style-1">									
								<form action="" method="post" id="myForm" enctype="multipart/form-data">
									<div class="row"> 
										<div class="afmb-3">
											<label for="exampleInputname" class="form-label-af">First Name <span class="text-danger">*</span></label>
											<input type="text" name="first_name" class="form-control-af" id="exampleInputname" aria-describedby="Fname" required>
										</div>
										<div class="afmb-3">
											<label for="exampleInputlast" class="form-label-af">Last Name <span class="text-danger">*</span></label>
											<input type="text" name="last_name" class="form-control-af" id="exampleInputlast" aria-describedby="Lname" required>
										</div>
										<div class="afmb-3">
											<label for="exampleInputpa" class="form-label-af">Present Address <span class="text-danger">*</span></label>
											<input type="text" name="present_address" class="form-control-af" id="exampleInputpa" aria-describedby="paddress" required>
										</div>
										<div class="afmb-3">
											<label for="exampleInputEmail1" class="form-label-af">Email address <span class="text-danger">*</span></label>
											<input type="email" name="email_address" class="form-control-af" id="exampleInputEmail1" aria-describedby="email" required>
										</div>
										<div class="afmb-3">
											<label for="exampleInputPhone" class="form-label-af">Mobile No <span class="text-danger">*</span></label>
											<input type="text" name="mobile_no" class="form-control-af" id="exampleInputPhone" aria-describedby="Phone" required>
										</div>
										<div class="afmb-3">
											<label for="exampleInputPostname" class="form-label-af">Post Name <span class="text-danger">*</span></label>
											<input type="text" name="post_name" value="<?php the_title();?>" class="form-control-af" id="exampleInputPostname" aria-describedby="Post" required>
										</div>
										<div class="afmb-3">
											<label for="exampleInputPostname" class="form-label-af">Upload CV (PDF,DOCS,JPG ETC)</label>
											<input type="file" name="cv" class="form-control-af" id="exampleInputPostname" aria-describedby="cv_upload" multiple="false">
										</div> 
										<!-- form   --> 	
										<div class="col-xl-12 col-lg-12 col-md-12"> 
											<div class="text-left">
											<button type="submit" name="submit" class="btn-af btn-primary-af site-button">Submit</button> 
											</div>
										</div> 
									</div>								
								</form>
							</div>  
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>	
</div>
<?php endwhile;  ?> 
<?php get_footer()?>