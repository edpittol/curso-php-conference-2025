<?php
/**
 * Plugin Name: SQLite integration (Drop-in)
 * Version: 1.0.0
 * Author: WordPress Performance Team
 * Author URI: https://make.wordpress.org/performance/
 *
 * This file is auto-generated and copied from the sqlite plugin.
 * Please don't edit this file directly.
 *
 * @package wp-sqlite-integration
 */

define( 'SQLITE_DB_DROPIN_VERSION', '1.8.0' );

// Tweak to allow copy-pasting the file without having to run string-replacements.
$sqlite_plugin_implementation_folder_path = '/app/vendor/lucatume/wp-browser/includes/sqlite-database-integration';
if ( ! file_exists( $sqlite_plugin_implementation_folder_path ) ) { // Check that the folder exists.
	$sqlite_plugin_implementation_folder_path = realpath( __DIR__ . '/plugins/sqlite-database-integration' );
}

// Bail early if the SQLite implementation was not located in the plugin.
if ( ! $sqlite_plugin_implementation_folder_path || ! file_exists( $sqlite_plugin_implementation_folder_path . '/wp-includes/sqlite/db.php' ) ) {
	return;
}

// Constant for backward compatibility.
if ( ! defined( 'DATABASE_TYPE' ) ) {
	define( 'DATABASE_TYPE', 'sqlite' );
}
// Define SQLite constant.
if ( ! defined( 'DB_ENGINE' ) ) {
	define( 'DB_ENGINE', 'sqlite' );
}

// Require the implementation from the plugin.
require_once $sqlite_plugin_implementation_folder_path . '/wp-includes/sqlite/db.php';

