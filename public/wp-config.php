<?php

/**
 * MySQL
 */
define( 'DB_ENGINE', $_SERVER['DB_ENGINE'] ?? 'mysql' );
define( 'DB_NAME', $_SERVER[ 'MYSQL_DATABASE' ] );
define( 'DB_USER', $_SERVER[ 'MYSQL_USER' ] );
define( 'DB_PASSWORD', $_SERVER[ 'MYSQL_PASSWORD' ] );
define( 'DB_HOST', $_SERVER[ 'MYSQL_HOST' ] );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', ''  );

/**
 * Authentication Unique Keys and Salts.
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

/**
 * Custom content directory.
 */
define( 'WP_HOME', $_ENV[ 'HOME_URL' ] );
define( 'WP_SITEURL', WP_HOME . '/wp' );
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/packages' );
define( 'WP_CONTENT_URL', WP_HOME . '/packages' );

/**
 * Define ssh2 para forçar falha de escrita. O objetivo é não escrever nenhum
 * arquivo pelo PHP-FPM, apenas pelo WP-CLI
 */
define( 'FS_METHOD', 'direct' );

/**
 * Desabilita cron para melhorar a experiência dos testes
 */
define( 'DISABLE_WP_CRON', true );

/**
 * Absolute path to the WordPress directory.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/wp/' );
}

/**
 * Sets up WordPress vars and included files.
 */
require_once( ABSPATH . 'wp-settings.php' );
