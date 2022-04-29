<?php
/**
 * Provides functions to fetch information and interact with the current project.
 */

namespace TEC\Tric;

function get_project_type() {
	$plugins_dir = realpath( getenv( 'TRIC_PLUGINS_DIR' ) );
	$themes_dir  = realpath( getenv( 'TRIC_THEMES_DIR' ) );
	$here_dir    = realpath( getenv( 'TRIC_HERE_DIR' ) );
	$is_plugin   = $here_dir === $plugins_dir;
	$is_theme    = $here_dir === $themes_dir;
	if ( ! ( $is_plugin || $is_theme ) ) {
		return 'site';
	}

	return $is_theme ? 'theme' : 'plugin';
}

function get_project_local_path() {
	switch ( get_project_type() ) {
		case 'plugin':
			return realpath( getenv( 'TRIC_PLUGINS_DIR' ) ) . DIRECTORY_SEPARATOR . tric_target();
		case 'theme':
			return realpath( getenv( 'TRIC_THEMES_DIR' ) ) . DIRECTORY_SEPARATOR . tric_target();
		default:
			return realpath( getenv( 'TRIC_HERE_DIR' ) );
	}
}

function get_project_container_path() {
	switch ( get_project_type() ) {
		case 'plugin':
			return '/var/www/html/wp-content/plugins' . '/' . tric_target();
		case 'theme':
			return '/var/www/html/wp-content/themes' . '/' . tric_target();
		default:
			return '/var/www/html';
	}
}
