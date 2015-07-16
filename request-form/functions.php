<?php

/*add_shortcode('request_select_sc', 'request_select');

function request_select() {
	
	require_once ( 'handling.php' );

	if (isset($_POST['request_select'])) {
	    echo request_select_handling();
	    return;
	}

echo '<form method="post" action="" id="request_form">
	<section>
		<input type="submit" name="request_select" value="Development" class="submit" />
		<input type="submit" name="request_select" value="Design" class="submit" />
		<input type="submit" name="request_select" value="Update" class="submit" />
		<input type="submit" name="request_select" value="Support" class="submit" />
		<input type="submit" name="request_select" value="Other" class="submit" />
	</section>
</form>';
		
}
*/

add_shortcode('multipage_form_sc', 'multipage_form');

function multipage_form() {
	global $wpdb;
	$this_page = $_SERVER['REQUEST_URI'];
	$page = $_POST['page'];
	$request_title = get_the_title();

	// Some JS is used in javascript/main.js
	if ($request_title == 'Support' && $page == NULL) {
		echo '<form method="post" action="' . $this_page . '" id="support" enctype="multipart/form-data">
			<div class="support_select">
		  		<label><input type="radio" name="support" id="bug_fix" value="1" />Bug fix</label>
				<label><input type="radio" name="support" id="third_party_sites" value="2" />Third-party websites</label>
			</div>
			<section>
				<div id="bugfix_select" class="block">
					<p>
						<input type="text" class="" name="bf_url" id="bf_url" placeholder="Website URL" />
					</p>
					<p>
						<textarea class="" id="bf_desc" name="bf_desc"></textarea>
					</p>
				</div>
				<div id="tpw_select" class="block">
					<p>
						<input type="text" class="" id="tpw_url" name="tpw_url" placeholder="Website URL" />
					</p>
					<p>
						<input type="date" class="" id="tpw_date" name="tpw_date" />
					</p>
					<p>
						<input type="text" class="" id="tpw_date_reason" name="tpw_date_reason" />
					</p>
					<p>
						<input type="file" class="" id="tpw_asset" name="tpw_asset" />
					</p>
					<p>
						<textarea class="" id="tpw_desc" name="tpw_desc"></textarea>
					</p>
				</div>
				<input type="hidden" value="1" name="page" />
				<input type="submit" value="Next" class="submit-next" />
			</section>
		</form>';
		
	}
	// End of page 1 for Support
	elseif ($request_title == 'Support' && $page == 1) {
		$support_select = $_POST['support'];

		
		if ($support_select == '1') {
			$option_name = 'Bug Fix';
			$url = $_POST['bf_url'];
			$desc = $_POST['bf_desc'];
			
			$page_one_table = 'request_form';
			$page_one_inputs =  array(
				'request_select' => $request_title,
				'option_select' => $support_select,
				'option_name' => $option_name,
				'url' => $url,
				'description' => $desc,
				'page' => $page
			);
			
			//  Insert the data into a new row
			$insert_page_one  =   $wpdb->insert($page_one_table, $page_one_inputs);
			//    Grab the ID of the row we inserted for later use
			$form_id = $wpdb->insert_id;
			

		} else if ($support_select == '2') {
			if ($_FILES) {
				if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
				
				$uploadedfile = $_FILES['tpw_asset'];
				$upload_overrides = array( 'test_form' => false );
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
				    if ( $movefile ) {
				        echo "File is valid, and was successfully uploaded.\n";
				    } else {
				        echo "Possible file upload attack!\n";
				    } 
			}
			
			$option_name = 'Third Party Website';
			$url = $_POST['tpw_url'];
			$desc = $_POST['tpw_desc'];
			$deadline = $_POST['tpw_date'];
			$deadline_reason = $_POST['tpw_date_reason'];
			
			$page_one_table = 'request_form';
			$page_one_inputs =  array(
				'request_select' => $request_title,
				'option_select' => $support_select,
				'option_name' => $option_name,
				'url' => $url,
				'asset_upload' => $movefile['file'],
				'description' => $desc,
				'deadline' => $deadline,
				'deadline_reason' => $deadline_reason,
				'page' => $page
			);
		
			//  Insert the data into a new row
			$insert_page_one  =   $wpdb->insert($page_one_table, $page_one_inputs);
			//    Grab the ID of the row we inserted for later use
			$form_id = $wpdb->insert_id;

		}
		echo '<h3>Contact Details</h3> ';
		echo '<form method="post" action="' . $this_page .'">
			<p><input type="text" name="person_name" id="person_name" placeholder="Your name, please" /></p>
			<p><input type="email" name="email" id="email" placeholder="Email" /></p>
			<p><input type="text" name="sign_off_name" id="sign_off_name" placeholder="Sign off contact (optional)" /></p>
			<input type="hidden" value="2" name="page" />
			<input type="hidden" value="' . $form_id . '" name="form_id" />
			<input type="submit" value="Submit" />
		</form>';

	}
	// End of page 2 of Support and start of page 1 for Update
	elseif ($request_title == 'Update' && $page == NULL) {
		echo '<form method="post" action="' . $this_page . '" id="update" enctype="multipart/form-data">
			<div class="update_select">
		  		<label><input type="radio" name="update" id="content_update" value="1" />Content Update</label>
				<label><input type="radio" name="update" id="new_feature" value="2" />New Feature</label>
			</div>
			<section>
				<div id="content_select" class="block">
					<p>
						<input type="text" class="" name="cu_url" id="rf_url" placeholder="Website URL" />
					</p>
					<p>
						<input type="date" class="" id="cu_date" name="cu_date" />
					</p>
					<p>
						<input type="date" class="" id="cu_date_reason" name="cu_date_reason" />
					</p>
					<p>
						<textarea class="" id="cu_desc" name="cu_desc"></textarea>
					</p>
				</div>
				<div id="feature_select" class="block">
					<p>
						<input type="text" class="" id="fs_url" name="fs_url" placeholder="Website URL" />
					</p>
					<p>
						<input type="date" class="" id="fs_date" name="fs_date" />
					</p>
					<p>
						<input type="date" class="" id="fs_date_reason" name="fs_date_reason" />
					</p>
					<p>
						<input type="file" class="" id="fs_asset" name="fs_asset" />
					</p>
					<p>
						<textarea class="" id="fs_desc" name="fs_desc"></textarea>
					</p>
				</div>
				<input type="hidden" value="1" name="page" />
				<input type="submit" value="Next" class="submit-next" />
			</section>
		</form>';
		
	}
	//End Page 1 of Update
	elseif ($request_title == 'Update' && $page == 1) {
		$update_select = $_POST['update'];
		
		if ($update_select == '1') {
			$option_name = 'Content';
			$url = $_POST['cu_url'];
			$deadline = $_POST['cu_date'];
			$deadline_reason = $_POST['cu_date_reason'];
			$desc = $_POST['cu_desc'];
			
			$page_one_table = 'request_form';
			$page_one_inputs =  array(
				'request_select' => $request_title,
				'option_select' => $update_select,
				'option_name' => $option_name,
				'url' => $url,
				'deadline' => $deadline,
				'deadline_reason' => $deadline_reason,
				'description' => $desc,
				'page' => $page
			);
			
			//  Insert the data into a new row
			$insert_page_one  =   $wpdb->insert($page_one_table, $page_one_inputs);
			//    Grab the ID of the row we inserted for later use
			$form_id = $wpdb->insert_id;
			
			
			
		} else if ($update_select == '2') {
			if ($_FILES) {
				if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
				
				$uploadedfile = $_FILES['fs_asset'];
				$upload_overrides = array( 'test_form' => false );
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
				    if ( $movefile ) {
				        echo "File is valid, and was successfully uploaded.\n";
				    } else {
				        echo "Possible file upload attack!\n";
				    } 
			}
			
			$option_name = 'New Feature';
			$url = $_POST['fs_url'];
			$desc = $_POST['fs_desc'];
			$deadline = $_POST['sf_date'];
			$deadline_reason = $_POST['fs_date_reason'];
			
			$page_one_table = 'request_form';
			$page_one_inputs =  array(
				'request_select' => $request_title,
				'option_select' => $update_select,
				'option_name' => $option_name,
				'url' => $url,
				'asset_upload' => $movefile['file'],
				'description' => $desc,
				'deadline' => $deadline,
				'deadline_reason' => $deadline_reason,
				'page' => $page
			);
		
			//  Insert the data into a new row
			$insert_page_one  =   $wpdb->insert($page_one_table, $page_one_inputs);
			//    Grab the ID of the row we inserted for later use
			$form_id = $wpdb->insert_id;

		}
		echo '<h3>Contact Details</h3> ';
		echo '<form method="post" action="' . $this_page .'">
			<p><input type="text" name="person_name" id="person_name" placeholder="Your name, please" /></p>
			<p><input type="email" name="email" id="email" placeholder="Email" /></p>
			<p><input type="text" name="sign_off_name" id="sign_off_name" placeholder="Sign off contact (optional)" /></p>
			<input type="hidden" value="2" name="page" />
			<input type="hidden" value="' . $form_id . '" name="form_id" />
			<input type="submit" value="Submit" />
		</form>';

	}
	//End Page 2 of Update
	elseif ($request_title == 'Design' && $page == NULL) {
		echo '<form method="post" action="' . $this_page . '" id="design" enctype="multipart/form-data">

				<p>
					<input type="text" class="" name="rf_brand" id="rf_brand" placeholder="Brand" />
				</p>
				<p>
					<input type="text" class="" name="rf_channel" id="rf_channel" placeholder="Channel" />
				</p>
				<p>
					<input type="text" class="" name="rf_project" id="rf_project" placeholder="Project" />
				</p>
				<p>Please, describe the project and items required (e.g. banner, website, illustration, social).</p>
				<p>
					<textarea class="" id="rf_desc" name="rf_desc"></textarea>
				</p>
				<p>
					<input type="date" class="" id="rf_date" name="rf_date" />
				</p>
				<p>
					<input type="text" class="" id="rf_date_reason" name="rf_date_reason" />
				</p>
				<p>Please attach a separate copy document, a mood board and anything else required in a zip-file.</p>
				<p>
					<input type="file" class="" id="rf_asset" name="rf_asset" />
				</p>
				<p>Creative design</p>
				<p>
					<label>Who are we talking to?</label>
					<textarea class="" id="rf_question_1" name="rf_question_1"></textarea>
				</p>
				<p>
					<label>What do we already know?</label>
					<textarea class="" id="rf_question_2" name="rf_question_2"></textarea>
				</p>
				<p>
					<label>How do you intend to intrigue the consumer?</label>
					<textarea class="" id="rf_question_3" name="rf_question_3"></textarea>
				</p>
				<p>
					<label>What is the main message?</label>
					<textarea class="" id="rf_question_4" name="rf_question_4"></textarea>
				</p>
			<input type="hidden" value="1" name="page" />
			<input type="submit" value="Next" class="next" />
		</form>';
		
	}
	// End of page 1 for Design
	elseif ($request_title == 'Design' && $page == 1) {
		$design_select = $_POST['design'];
		

		if ($_FILES) {
			if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
			
			$uploadedfile = $_FILES['rf_asset'];
			$upload_overrides = array( 'test_form' => false );
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			    if ( $movefile ) {
			        echo "File is valid, and was successfully uploaded.\n";
			    } else {
			        echo "Possible file upload attack!\n";
			    } 
		}
		
		$option_name = $_POST['rf_project'];
		$brand = $_POST['rf_brand'];
		$channel = $_POST['rf_channel'];
		$desc = $_POST['rf_desc'];
		$question_1 = $_POST['rf_question_1'];
		$question_2 = $_POST['rf_question_2'];
		$question_3 = $_POST['rf_question_3'];
		$question_4 = $_POST['rf_question_4'];
		$final_desc = "<p><strong>Brand:</strong> " . $brand . "</p><p><strong>Channel:</strong> " . $channel . "</p><strong>Description:</strong> " . $desc . "</p><p><strong>Who are we talking to?</strong> " . $question_1 . "</p><p><strong>What do we already know?</strong> " . $question_2 . "</p><p><strong>How do you intend to intrigue the consumer?</strong> " . $question_3 . "</p><p><strong>What is the main message?</strong> " . $question_4 . "</p>";
		$deadline = $_POST['rf_date'];
		
		//json_decode($desc);
		
		$page_one_table = 'request_form';
		$page_one_inputs =  array(
			'request_select' => $request_title,
			'option_select' => $design_select,
			'option_name' => $option_name,
			'url' => $url,
			'asset_upload' => $movefile['file'],
			'description' => $final_desc,
			'deadline' => $deadline,
			'page' => $page
		);
	
		//  Insert the data into a new row
		$insert_page_one  =   $wpdb->insert($page_one_table, $page_one_inputs);
		//    Grab the ID of the row we inserted for later use
		$form_id = $wpdb->insert_id;

		
		echo '<h3>Contact Details</h3> ';
		echo '<form method="post" action="' . $this_page .'">
			<p><input type="text" name="person_name" id="person_name" placeholder="Your name, please" /></p>
			<p><input type="email" name="email" id="email" placeholder="Email" /></p>
			<p><input type="text" name="sign_off_name" id="sign_off_name" placeholder="Sign off contact (optional)" /></p>
			<input type="hidden" value="2" name="page" />
			<input type="hidden" value="' . $form_id . '" name="form_id" />
			<input type="submit" value="Submit" />
		</form>';

	}
	//End Page 2 of Design
	elseif ($request_title == 'Other' && $page == NULL) {
		echo '<form method="post" action="' . $this_page . '" id="other" enctype="multipart/form-data">

			<div class="other_select">
		  		<label><input type="radio" name="other" id="domain" value="1" />Is it a domain issue?</label>
				<label><input type="radio" name="other" id="discount_code" value="2" />You need a discount code for a book campaign?</label>
				<label><input type="radio" name="other" id="handover" value="3" />The website needs to be handed over to author, agency or another publisher?</label>
				<label><input type="radio" name="other" id="consultation" value="4" />Maybe you need a consultation on a project or an issue?</label>
				<label><input type="radio" name="other" id="other" value="5" />OK. We are out of options. What happened?</label>
			</div>
			<section>
				<div id="it_select" class="block">
					<p>
						Please, contact Service Desk by phone (extension x5900) or email (IT Service Desk (@RH, UK) <ITServiceDesk@penguinrandomhouse.co.uk>). Remember to mention the subject of your issue whether it\'s a domain, discount code or website handover.
					</p>
					<p>Still not sure? How about a consultation about your issue?</p>
				</div>
				<div id="consultation_select" class="block">
					<p>
						<input type="text" class="" name="oc_project" id="oc_project" placeholder="Project name" />
					</p>
					<p>
						<input type="text" class="" name="cu_url" id="rf_url" placeholder="Does it have a URL yet?" />
					</p>
					<p>
						<input type="date" class="" id="cu_date" name="cu_date" placeholder="Deadline" />
					</p>
					<p>
						<textarea class="" id="oc_desc" name="oc_desc"></textarea>
					</p>
				</div>
				<div id="other_select" class="block">
					<p>
						<textarea class="" id="fs_desc" name="fs_desc"></textarea>
					</p>
				</div>
				<input type="hidden" value="1" name="page" />
				<input type="submit" value="Next" class="submit-next" />
			</section>
		</form>';
		
	}
	//End Page 1 of Other
	elseif ($request_title == 'Other' && $page == 1) {
		$other_select = $_POST['other'];
		
		if ($other_select == '1') {
		
			
		} elseif ($other_select == '2') {
	

		}
		} elseif ($other_select == '3') {
	

		} elseif ($other_select == '4') {
	

		} elseif ($other_select == '5') {
	

		}
		echo '<h3>Contact Details</h3> ';
		echo '<form method="post" action="' . $this_page .'">
			<p><input type="text" name="person_name" id="person_name" placeholder="Your name, please" /></p>
			<p><input type="email" name="email" id="email" placeholder="Email" /></p>
			<p><input type="text" name="sign_off_name" id="sign_off_name" placeholder="Sign off contact (optional)" /></p>
			<input type="hidden" value="2" name="page" />
			<input type="hidden" value="' . $form_id . '" name="form_id" />
			<input type="submit" value="Submit" />
		</form>';

	}


	//End Page 2 of Other
	// Contact Details page and send to email and Taiga.io
	elseif ( $page == 2 ) {
		$person_name = $_POST['person_name'];
		$email = $_POST['email'];
		$sign_off_name = $_POST['sign_off_name'];
		$page = $_POST['page'];
		$form_id = $_POST['form_id'];
		
		$page_two_table = 'request_form';
		$page_two_inputs = array(
			'person_name' => $person_name,
			'email' => $email,
			'sign_off_name' => $sign_off_name,
			'page' => $page
		);
		$page_two_where = array(
			'id' => $form_id
		);
		 
		$insert_page_two = $wpdb -> update($page_two_table, $page_two_inputs, $page_two_where);
		
		//Send email with confirmation to the team and back to the requester
		$data_check = $wpdb->get_row("SELECT * FROM request_form WHERE id = '$form_id'");
		$team_email = 'kkanter@penguinrandomhouse.co.uk';
		$request_email = $data_check->email;
		$multiple_recipients = array($team_email, $request_email);
		
		$subj = 'Request Form – '.$data_check->request_select .' – '. $data_check->option_name;
		
		//Body of email message
		if($data_check->option_name == 'Support' || $data_check->option_name == 'Update' ) {
			$body = "<p>Website URL: ".$data_check->url."</p><p>Description: ".$data_check->description . "</p><p>Deadline: ".$data_check->deadline."</p><p>Contact Person: ".$data_check->person_name . "</p><p>Email: ".$data_check->email. "</p><p>Sign-off: " . $data_check->sign_off_name ."</p>";
		} else {
			$body = "<p>Description: ".$data_check->description . "</p><p>Deadline: ".$data_check->deadline."</p><p>Contact Person: ".$data_check->person_name . "</p><p>Email: ".$data_check->email . "</p><p>Sign-off: " . $data_check->sign_off_name ."</p>";
		}
		
		// Headers and attachments
		$headers .= 'Content-Type: text/html; charset=utf-8';
		$attachments = array($data_check->asset_upload);
		
		if (wp_mail($multiple_recipients, $subj, $body, $headers, $attachments)) {
		    $email_sent = true;
		} else {
		    $email_sent_error = true;
		}
		
		// Confirmation
		if (isset($email_sent) && $email_sent == true) {
		
		echo '<h3>Thanks!</h3>';
		echo '<p>We very much appreciate you taking the time to fill out this form! You\'re all done!</p>';
		echo '<a href="/request-form">Start again?</a>';
		
		// Taiga REST API, take the data from DB and send to Backlog Project
		$data_check = $wpdb->get_row("SELECT * FROM request_form WHERE id = '$form_id'");
		// Change API for a new user and a new project
		$taigatoken = 'eyJ1c2VyX2F1dGhlbnRpY2F0aW9uX2lkIjozNjk0M30:1YqOI6:DAFMt2JiED-HiZ2x8IYrluKbLWA';
		
		$taigaheader = array(
			'header' => 'Content-Type: application/json',
			'header' => 'Authorization: Bearer ' . $taigatoken
		);
		
		// Encode subject and description for better readability
		if($data_check->option_name == 'Support' || $data_check->option_name == 'Update' ) {
			$data_subject = $data_check->option_name . ' – ' . $data_check->url;
			$data_description = '<p>URL: '. $data_check->url .'</p><p>Deadline: ' . $data_check->deadline .'</p><p>Description: '.$data_check->description.'</p><p>Contact Person: ' . $data_check->person_name . '</p><p>Email: ' . $data_check->email . '</p><p>Sign-off: ' . $data_check->sign_off_name . '</p>';
		} else {
			$data_subject = $data_check->option_name;
			$data_description = $data_check->description.'<p>Deadline: ' . $data_check->deadline .'</p><p>Contact Person: ' . $data_check->person_name . '</p><p>Email: ' . $data_check->email . '</p><p>Sign-off: ' . $data_check->sign_off_name . '</p>';
		}
		json_encode($data_subject);
		json_encode($data_description);
		
		// Insert the data into Taiga.io
		$data = array(
			'project' => 42260,
			'subject' => $data_subject,
			'description' => $data_description
		);
		
		# Create a connection
		$url = 'https://api.taiga.io/api/v1/userstories';
		
		$ch = curl_init($url);

		# Form data string
		$postString = http_build_query($data, '', '&');
		
		# Setting our options
		curl_setopt($ch, CURLOPT_HTTPHEADER, $taigaheader);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		# Get the response
		$response = curl_exec($ch);

		if ($response === false) {
		    // throw new Exception('Curl error: ' . curl_error($crl));
		    print_r('Curl error: ' . curl_error($ch));
		}
		
		curl_close($ch);
		
		// Confirmation and attachments to Taiga.io
		} elseif (isset($email_sent_error) && $email_sent_error == true) {
			
		echo '<div data-alert class="alert-box alert">
			<p>There was an error!</p>
		</div>';
		// Attach the files to Taiga issue?
		
		}

	} // End Page 3 of Form
	
	
		
	
	// Let's check our data
	/*$data_check = $wpdb->get_row("SELECT * FROM request_form WHERE id = '$form_id'");
	 
	echo '
	<p> id: ' . $data_check->id . '</p>
	<p> Support: ' . $data_check->support_checked . '</p>
	<p> Website URL: ' . $data_check->url . '</p>
	<p> Description: ' . $data_check->description . '</p>
	<p> Deadline: ' . $data_check->deadline . '</p>
	<p> Assets: ' . $data_check->asset_upload . '</p>
	<p> Contact person: ' . $data_check->person_name . '</p>
	<p> Email: ' . $data_check->email . '</p>
	<p> Sign-off: ' . $data_check->sign_off_name . '</p>
	<p> page: ' . $data_check->page . '</p>
	<p> timestamp: ' . $data_check->timestamp . '</p>';*/
};

?>