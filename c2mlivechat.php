<?php
/*
Plugin Name: Click2Magic Live Chat
Description: Click2Magic Live chat software for live help, online sales and customer support. This plugin allows to quickly install Click2Magic LiveChat on any WordPress website.
Author: Click2Magic
Version: 1.2.1
Text Domain: c2m-live-chat
*/

namespace C2MLIVECHAT_SS\SRIDHAR\SRIRAMULA;

// Exit if accessed directly
defined('ABSPATH') or die();

/**
 * Plugin directory
 * @param const, C2MLIVECHAT_DIR
 */
define( 'C2MLIVECHAT_DIR', plugin_dir_path( __FILE__ ) );

class C2MLIVECHAT_SS_SOFTWARE_TOOLS {

	function __construct() {
		register_activation_hook(__FILE__, array($this, 'activate_c2mlivechat_tools')); // Register hook
		register_deactivation_hook(__FILE__, array($this, 'deactive_c2mlivechat_tools')); // Deactivation hook
		$this->admin_setup();
	}

	// Plugin activation hook
	function activate_c2mlivechat_tools() {
		
	}

	// Plugin deactivation hook
	function deactive_c2mlivechat_tools() {
		delete_option('c2mlivechat_setting');
	}

	// Register the setting
	function admin_init_c2mlivechat_tools() {
		register_setting('c2mlivechat_software_tools', 'c2mlivechat_setting');
	}

	// Options page
	function admin_menu_options_page() {
		if ( ! current_user_can('manage_options') )
			return;
		add_options_page(__('Click2Magic Live Chat', 'c2m-live-chat'), __('Click2Magic Live Chat', 'c2m-live-chat'), 'manage_options', 'c2mlivechat_software_tools', array($this, 'options_page_c2mlivechat_tools'));
	}
	
	// Options page content
	function options_page_c2mlivechat_tools() {
		include_once ( C2MLIVECHAT_DIR . '/includes/c2mlivechat-options.php' );
	}

	// Click2Magic Live Chat in action
	function c2mlivechat_tools() {
		$c2mlivechat_code = get_option('c2mlivechat_setting');
		?>

		<!-- Start Click2Magic Live Chat plugin for WordPress -->
		<?php //echo $c2mlivechat_code ?>

        <script>
            (function(d, s, id, ref){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = 'https://www.click2magic.com/chat-widget/<?php echo $c2mlivechat_code ?>';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'c2mApiJs'));
        </script>
        <!-- Stop Click2Magic Live Chat plugin for WordPress -->
		<?php
	}

	function my_plugin_action_links( $links ) {
	   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=c2mlivechat_software_tools') ) .'">Settings</a>';
	   return $links;
	}

	// Initial setup
	function admin_setup() {
		if ( is_admin() ) {
			add_action( 'admin_init', array($this, 'admin_init_c2mlivechat_tools') ); // Register setting hook
            add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
			add_action( 'admin_menu', array($this, 'admin_menu_options_page') ); // Options menu page hook
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'my_plugin_action_links') );
		}

		if ( ! is_admin() ) {
			add_action('wp_footer', array($this, 'c2mlivechat_tools')); // Display webmaster code
		}
	}
}
// Class initialization
if ( ! ( $c2mlivechat_sridhar_sriramula instanceof \C2MLIVECHAT_SS\SRIDHAR\SRIRAMULA\C2MLIVECHAT_SS_SOFTWARE_TOOLS ) )
    $c2mlivechat_sridhar_sriramula = new \C2MLIVECHAT_SS\SRIDHAR\SRIRAMULA\C2MLIVECHAT_SS_SOFTWARE_TOOLS();
?>