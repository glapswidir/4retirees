<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'retirees_live18');

/** MySQL database username */
define('DB_USER', 'retirees_wp267');

/** MySQL database password */
define('DB_PASSWORD', 'lo{$]o}{vfb?');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '=0^)]#FD@,v~4Ca36@DR56+<bj1;?BX;scR^YD/G!SNQIq5MfWt9e#n`Al}p5OGW');
define('SECURE_AUTH_KEY',  '$<$lml gIr5@uQ4AT=l$Y +{#3p6wi4kFy<z]t$Sz9P+87D^}:F]]Xrf@%PEd Kd');
define('LOGGED_IN_KEY',    'txGz&Bu5p;{?rZmA7 k?|XZ-rw?lwQE>J+cyZD_HYDE3,oLlSu*Imh#Huzjtc5=~');
define('NONCE_KEY',        'KVa4@+Lt/%at1rZ_]|1)X755|S5?NjEk-zoV.NA )h-D@s7b_(fjcQ!SQNg|h}m=');
define('AUTH_SALT',        'hdi<n:a`=KgSj3gdDTNMat^0 M#V%A^;rBoR[%j7{A._11EY >FZoz_k0eM#=cLh');
define('SECURE_AUTH_SALT', '*>{Uo!@{j*z79f8huYsY#,D5/RxihJG#i*IYh{(28i5.PqTn ua(v<D =gy<!2(j');
define('LOGGED_IN_SALT',   'QnI=Df|{lS6qiQIu.&q#ymNW9 <&J%F1%x~wKCt/19q4w+GpHpL8o$+k`m#`3Y`,');
define('NONCE_SALT',       'yoQ?O^,l?^j/})T$lnb69hv*uqy>nvQf4SOxy%5D5c@ca0h!k!L%BjBZ4:HCcJy$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = '4r_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
