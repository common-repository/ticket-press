<?php
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

remove_role( 'tp_operator');
remove_role( 'tp_customer');

$tp_general = get_option( 'tp_general');

wp_delete_post( $tp_general['my-tickets'], true);
wp_delete_post( $tp_general['new-ticket'], true );

delete_option( 'tp_general');
delete_option( 'tp_display');