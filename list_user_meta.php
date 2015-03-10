<?php
/*
Plugin Name: User Meta Profile List
Description:  Configures which user meta should display in a custom list.
Author: Richard Miles
Version: 0 
Author URI: http://richymiles.wordpress.com
*/



function user_meta_profile_list($profile) {
		global $wpdb;
		$results = $wpdb->get_results( "SELECT `meta_key` , `meta_value` FROM wp_usermeta WHERE `user_id` =  $profile->ID");
		if (get_option( 'user_meta_field_title' )) {
				echo '<h3>' . get_option( 'user_meta_field_title' ) .'</h3>';
		} else {
					echo '<h3>Other Information</h3>';
		}

		echo '<table class="form-table">';
		foreach ($results as $key => $result) {
			if (in_array($result->meta_key, get_option( 'user_meta_fields' ))) {
				if ($result->meta_value == 'false') {
					$result->meta_value = "";
				}
				echo '<tr>';
				echo '<th>' . $result->meta_key . '</th>';
				echo '<td><i>' . $result->meta_value . '</i></td>';
				echo '</tr>';
			}	
		}
		echo '</table>';
}
add_action('show_user_profile' , 'user_meta_profile_list' );
add_action('edit_user_profile' , 'user_meta_profile_list' );

add_action('admin_menu', 'add_list_options');

function add_list_options() {
	add_options_page('My Options', 'User Meta Profile Options', 'manage_options', plugin_dir_path( __FILE__ ) . 'admin.php');
}

function user_list_enqueue_admin() {
	wp_enqueue_style( 'multi-select	-css', plugins_url('css/multi-select.css', __FILE__) );
	wp_enqueue_script( 'multi-select-js', plugins_url('js/jquery.multi-select.js', __FILE__) );

}
add_action( 'admin_enqueue_scripts', 'user_list_enqueue_admin' , 0); 
