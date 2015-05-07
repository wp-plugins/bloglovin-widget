<?php

// If plugin is not being uninstalled, exit (do nothing)
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// delete database entries
delete_option( 'pipdig_bloglovin_plugin_url' );
delete_option( 'pipdig_bloglovin_follower_count' );