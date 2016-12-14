<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Uninstallation actions here

//remove the taxonomy that we created

$idObj = get_term_by( 'slug', 'dis_ro_bookings', 'product_cat'); 
$tt_id = $idObj->term_id;
wp_delete_term( $tt_id, 'product_cat' );


