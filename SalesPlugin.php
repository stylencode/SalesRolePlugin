<?php
/**
 * Plugin Name: Sales Role Plugin
 * Plugin URI: 
 * Description: Adds a custom 'Sales' user role and removes specific certain capabilities from it.
 * Version: 1.0.0
 * Author: Fuad Talybov
 * Author URI: 
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) || exit; // Prevent direct access to this file.

/**
 * Main plugin class.
 */
class Sales_Role_Plugin {

 /**
 * Initializes the plugin.
 */
 public function __construct() {
 add_action( 'init', array( $this, 'add_sales_role' ) );
 add_action( 'init', array( $this, 'revoke_sales_capabilities' ), 10 );
 }

 /**
 * Adds a 'Sales' user role.
 */
 public function add_sales_role() {
 global $wp_roles;

 if ( ! isset( $wp_roles ) ) {
 $wp_roles = new WP_Roles();
 }

 // Adding a 'new_role' with all admin caps.
 $capabilities = get_role( 'administrator' )->capabilities;
 $wp_roles->add_role( 'sales', 'Sales', $capabilities );
 }

 /**
 * Remove User editing capabilities for the 'Sales' user role.
 */
 public function revoke_sales_capabilities() {
 $caps_to_remove = array(
 'update_core',
 'activate_plugins',
 'install_plugins',
 'update_plugin',
 'edit_plugins',
 'edit_themes',
 'export',
 'import',
 'create_users',
 'list_users',
 'manage_options',
 'switch_themes',
 );

 $custom_role = get_role( 'sales' );

 // Check if the user is the specific user you want to remove the menu for
if ($custom_role == 'sales' || $custom_role == 'Sales') { 
	// Remove Users and Plugin menu
	remove_menu_page( 'users.php' );
	remove_menu_page( 'plugins.php' );
}

foreach ( $caps_to_remove as $cap ) {
$custom_role->remove_cap( $cap );
}
}
}

new Sales_Role_Plugin();