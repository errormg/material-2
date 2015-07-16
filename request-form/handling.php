<?php
function request_select_handling() {
	global $wpdb;
	
	$request_select = $_POST['request_select'];
	$request_start_table = 'request_form';
	$request_start_inputs = array(
		'request_select' => $request_select
	);
	
	//  Insert the data into a new row
	$insert_request_select = $wpdb -> insert($request_start_table, $request_start_inputs);
	
	switch ($_POST['request_select']) {
	case 'Development' :
		wp_redirect( 'http://www.devdesignteam.com/request-form/development/' );
		exit;
		break;

	case 'Design' :
		wp_redirect( 'http://www.devdesignteam.com/request-form/design/' );
		exit;
		break;

	case 'Update' :
		wp_redirect( 'http://www.devdesignteam.com/request-form/update/' );
		exit;
		break;
	
	case 'Support' :
		?>
		<script>
			window.location.href = "http://www.devdesignteam.com/request-form/support/";
		</script>
		<?php
		exit;
		break;
		
	case 'Other' :
		wp_redirect( 'http://www.devdesignteam.com/request-form/other/' );
		exit;
		break;
}
}


?>