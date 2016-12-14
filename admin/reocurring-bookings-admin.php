<?php
/*  Building the admin screen found under Bookings->Create Reoccurring Bookings
	Must have Woocommerce Product Add-ons installed
	

*/

//Creation of Function to produce json export for bookings/woocommerce add-on	
//add_action( 'admin_action_dis_wc_reoccurring', 'dis_wc_ro_product_addon_export' );
function dis_wc_ro_product_addon_export() {
	
	// get variables from form submission
	//need to count the number of course options to set $options
	//$required is  0 for false and 1 for true
	$options = array();
	$required = $_POST['dis_wc_ro_required'];
	$cost = absint($_POST['dis_wc_ro_base_cost']);
	if($_POST['dis_wc_ro_course1']) {
		$course_1 = $_POST['dis_wc_ro_course1'];
		$c_cost_1 =absint( ($cost*$course_1)-$cost);
		$cs_length_1 = strlen($course_1.' weeks');
		$ccs_length_1 = strlen($c_cost_1);
		$options[] = $c_cost_1;
		$ccs_length = strlen($c_cost_1);
	}
	if($_POST['dis_wc_ro_course2']) {
		$course_2 = $_POST['dis_wc_ro_course2'];
		$c_cost_2 =absint( ($cost*$course_2)-$cost);
		$cs_length_2 = strlen($course_2.' weeks');
		$ccs_length_2 = strlen($c_cost_2);
		$options[] = $c_cost_2;

	}
	if($_POST['dis_wc_ro_course3']) {
		$course_3 = $_POST['dis_wc_ro_course3'];
		$c_cost_3 =absint( ($cost*$course_3)-$cost);
		$cs_length_3 = strlen($course_3.' weeks');
		$ccs_length_3 = strlen($c_cost_3);
		$options[] = $c_cost_3;

	}

	
	$count = count($options);
	
	
	$out= 'a: 1: {i: 0;a: 8: { s: 4: "name";s: 13: "Course Length";s: 11: "description";s: 0: "";s: 4: "type";s: 6: "select";s: 8: "position";i: 0;s: 7: "options";a: '.$count.': {';
	//this section is repeated by the number of $options
	for ($i = 1; $i <= $count; $i++) {
		    $out .= 'i: '.($i-1).';a: 4: {s: 5: "label";s: '.${'cs_length_'.$i}.': "'.${'course_'.$i}.' weeks";s: 5: "price";s: '.${'ccs_length_'.$i}.': "'.${'c_cost_'.$i}.'";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";}';
	}
	//$out .= '		i: 0;a: 4: {
	//			        s: 5: "label";s: 7: "'.$course1.' weeks";s: 5: "price";s: 2: "'.$c1_cost.'";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
	//			      }i: 1;a: 4: {
	//			        s: 5: "label";s: 7: "'.$course2.' weeks";s: 5: "price";s: 2: "'.$c2_cost.'";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
	//			      }i: 2;a: 4: {
	//			        s: 5: "label";s: 8: "10 weeks";s: 5: "price";s: 2: "45";s: 3: "min";s: 0: "";s: 3: "max";s: 0: "";
	//			      }';
	// ability to set person and block multiplier could be here or maybe let use decide on main admin end?
	// allowing to set if required not setting allows for single booking under same product
	$out .= '}s: 8: "required";i: '.$required.';s: 32: "wc_booking_person_qty_multiplier";i: 0;s: 31: "wc_booking_block_qty_multiplier";i: 1;}}';
	
	$regex = '~"[^"]*"(*SKIP)(*F)|\s+~';
	$out = preg_replace($regex, '', $out);
	return $out;	
	//wp_redirect( $_SERVER['HTTP_REFERER'] );
   // exit();

}

