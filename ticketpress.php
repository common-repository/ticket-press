<?php
/*
Plugin Name: TicketPress
Description: A plugin for managing support tickets
Plugin URI: http://wordpress.org/plugins/support-press
Author: Abiral Neupane
Author URI: http://abiralneupane.com.np
Version: 1.4.1
License: GPL2
Text Domain: ticketpress
Domain Path: /languages/
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}


define('TICKETPRESS_DIR', dirname( __FILE__ ) );

require_once (dirname(__FILE__).'/includes/tp-install.php');

require_once (dirname(__FILE__).'/includes/functions.helpers.php');
require_once (dirname(__FILE__).'/includes/form_actions.php');

require_once (dirname(__FILE__).'/admin/class.admin.php');
require_once (dirname(__FILE__).'/admin/class.tickets-meta.php');
require_once (dirname(__FILE__).'/admin/class.settings.php');
require_once (dirname(__FILE__).'/admin/class.admin-fields.php');

require_once (dirname(__FILE__).'/classes/class.scripts.php');
require_once (dirname(__FILE__).'/classes/class.frontview.php');

register_activation_hook( __FILE__, 'tp_gather_up' );

$GLOBALS['tp_admin'] = new TP_ADMIN_MANAGEMENT();
$GLOBALS['tp_load_scripts'] = new TP_LOAD_SCRIPTS();
$GLOBALS['tp_tickets_meta'] = new TP_TICKETS_META();
$GLOBALS['tp_admin_settings'] = new TP_ADMIN_SETTINGS();
$GLOBALS['tp_admin_fields'] = new TP_ADMIN_FIELDS();
$GLOBALS['tp_frontview'] = new TP_FRONTVIEW();

