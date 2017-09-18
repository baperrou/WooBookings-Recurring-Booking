<?php
/*
Plugin Name: Do It Simply Recurring WooBookings by Week
Description: WooCommerce Bookings add-on
Version: 0.2.0
Author: DO IT SIMPLY LTD
Author URI: http://doitsimply.co.uk/
GitHub URI: baperrou/WooBookings-Recurring-Booking
*/

defined( 'ABSPATH' ) or exit;
// decide if the other plugins must be activated to use.
//revisit

define ( 'WCCF_NAME', 'Woocommerce Plugin Example' ) ;
define ( 'WCCF_REQUIRED_PHP_VERSION', '5.4' ) ;                          // because of get_called_class()
define ( 'WCCF_REQUIRED_WP_VERSION', '4.6' ) ;                          // because of esc_textarea()
define ( 'WCCF_REQUIRED_WC_VERSION', '2.6' );                           // because of Shipping Class system

// ADD ACTIONS AND ADMIN MENUS

//build the admin page for viewing
function dis_wc_build_admin() {
    include('views/dis-wc-recurring-admin.php');
    
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


//build menu item under tools to access plugin
function dis_wc_admin_actions() {
 	add_submenu_page( 'edit.php?post_type=wc_booking', "Create Recurring Bookings", "Create Recurring Bookings", 8, "dis-wc-recurring-admin", "dis_wc_build_admin");
 	//add_submenu_page( 'edit.php?post_type=wc_booking', __( 'Reoccurring Bookings', 'woocommerce-bookings' ), __( 'Reoccurring Bookings', 'woocommerce-bookings' ), 'dis-wc-reoccurring-admin', 'dis_wc_build_admin', 6 );
 	include('admin/recurring-bookings-admin.php');
}
 
add_action('admin_menu', 'dis_wc_admin_actions');





/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function wccf_requirements_met () {
    
    if ( ! is_plugin_active ( 'woocommerce-bookings/woocommmerce-bookings.php' ) ) {
        return false ;
    }
    if ( ! is_plugin_active ( 'woocommerce-product-addons/woocommerce-product-addons.php' ) ) {
        return false ;
    }

	/* if I want to add version control later    $woocommer_data = get_plugin_data(WP_PLUGIN_DIR .'/woocommerce-bookings/woocommmerce-bookings.php', false, false);

    if (version_compare ($woocommer_data['Version'] , WCCF_REQUIRED_WC_VERSION, '<')){
        return false;
    }
    */

    return true ;
}



// Create a product category to allow reoccurring bookings

function dis_wc_ro_insert_term()
{
    wp_insert_term(
      'Recurring Booking',
      'product_cat', // the taxonomy
      array(
        'description'=> 'A booking that is repeated for a certain number of weeks.',
        'slug' => 'dis_ro_bookings',
      )
    );
    //think about how to remove the tag if plugin removed.
}
add_action('init', 'dis_wc_ro_insert_term');

//now flush so the tage is activated.
function dis_wc_ro_flush_rewrites() {
	dis_wc_ro_insert_term();
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'dis_wc_ro_flush_rewrites' );


// Create an array of all products that have the Re-occurring booking category tag

function dis_wc_ro_get_products() {
	$args = array(
		'post_type' => 'product',
		'showposts' => '-1',
		'orderby' => 'id',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => 'dis_ro_bookings',
	
			),
		),
	);
	$dis_ro_products = get_posts($args);
	$product_array = array();
	foreach($dis_ro_products as $dis_product) {
		$product_array[] =$dis_product->ID;
	}
	return $product_array;

}
//*UPDATED 18 SEPT 2017 To accommodate latest woocommerce update 3.0 and make recurring happen when any type of payment is made.
// build the function after payment complete to create reoccurring booking
function dis_wc_ro_rb_payment_complete( $order_id ) {
	global $post;
	//check for reoccurring products 
	$dis_ro_order = new WC_Order( $order_id );
	$dis_ro_items  = $dis_ro_order->get_items();
	$booking= new WC_Booking_Data_Store($order_id);
	// get all parent ids of all bookings
	$booking_ids =$booking->get_booking_ids_from_order_id( $order_id );
	
	
	
	//now loop through the items searching for those that match Reoccurring Products
	// get the RC products
	$dis_ro_included = dis_wc_ro_get_products();
	
	foreach ($dis_ro_items as $var => $dis_ro_item) {
		if(in_array($dis_ro_item['product_id'], $dis_ro_included)) { 
			//now loop through an reoccurring bookiong product
			foreach($booking_ids as $booking_id) {
				//build the start time and end time
				//if not a full day booking then find start time and end time
				//unnecessary work, available in the get_wc_booking()
				/*if($dis_ro_item['Booking Time']):
					$time = $dis_ro_item['Booking Time'];
					// convert to unix
					$time= date("H:i", strtotime($time));
					$start_date = strtotime($dis_ro_item['Booking Date'].''.$time);
					$end_date = strtotime('+'.$dis_ro_item['Duration'], $date);
	
					$by_min = true;
				else:$by_day = true;
				endif;
				*/
				
				//need to get the meta data containing weeks (this is a dirty solution because the function 'wc_get_order_item_meta' should have a second parameter)
				$get_meta_data = wc_get_order_item_meta($var);
				

				//will need the resource id??
				//will need the add-on type
				foreach ($get_meta_data as $key => $get_meta) {
							
					 if(strpos($key, 'Length') !== false)  {
						$course_length = $get_meta_data[$key][0];
						echo $course_length;
						$course_array = preg_split('/\s+/', $course_length);
						$weeks = $course_array[0];
						echo $weeks;
					 }
				 }
				//?? do I need to force the add-on creation?  Copy and paste code??
				//use the import/export option format to create for user
				
				// get first booking details
				$prev_booking = get_wc_booking( $booking_id );
		
				// Don't want follow ups for follow ups
				if ( $prev_booking->parent_id <= 0 ) {
					//need to loop through booking based on number of weeks selected
					
					for ($class_length = 1; $class_length  <= ($weeks-1); $class_length++) {
				    	//need to decide if person option is needed then check if it exisits before useing
					
						create_wc_booking( 
							$prev_booking->product_id, // Creating a booking for the previous bookings product
							$new_booking_data = array(
								'start_date'  => strtotime( '+'.$class_length.' week', $prev_booking->start ), // same time, 1 week on
								'end_date'    => strtotime( '+'.$class_length.' week', $prev_booking->end ), // same time, 1 week on
								'resource_id' => $prev_booking->resource_id, // same resource
								'parent_id'   => $parent_id
							), 
							$prev_booking->get_status(), // Match previous bookings status
							false // Not exact, look for a slot
						);
					}
				}
								
			}
		}
	}
}
	

/// changed to hook into thank you message to insure booking sent

add_action( 'woocommerce_thankyou','dis_wc_ro_rb_payment_complete' );

//add_action( 'woocommerce_payment_complete','dis_wc_ro_rb_payment_complete' );

