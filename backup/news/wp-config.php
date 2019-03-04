<?php
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
define('DB_NAME', 'news');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'drjkzydrjkzy');

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
define('AUTH_KEY',         'Ow`f?wI906:(a6_4FB>xGH|*t}TZj.dl4p}7YWMp@dfCEtsR^uWS]VU)0_d_u_1G');
define('SECURE_AUTH_KEY',  'pE:mUbH;u,~+`X#2wK0z< l*j{zr.; ;O|RmEoz&w92M56DIA$zJ8B?~N~AmUawX');
define('LOGGED_IN_KEY',    'VA5W`FXNx]v0W`AIvQG38N~!^cVoX@3qz!B?XRD:)3!1NPbB34A|m(,BE8>5y:~?');
define('NONCE_KEY',        '7iS~nI4(b$R!z~>MD`NXCRn4. ej236y )K} I~3pCSrP&i[*5vn:N$O9ELML[,>');
define('AUTH_SALT',        '[a-6JBRYOgPnseA/4uSky*}./ fz34B-:!Y>JL(58J16W3(1;W%Q_PrS`dg(c1?+');
define('SECURE_AUTH_SALT', 'waw2{dIE^`ryDrW*xpiEsfvovQzYLFs]9F$1Myf(~!5*`/;5,R7N;JK9Y*X4k4u4');
define('LOGGED_IN_SALT',   'kZG.UDz/b;}opq$#;7n~1nx4b#]fvds^znl%oy}OY||m:gR@!X#{?eZyeGq^.I.I');
define('NONCE_SALT',       '>N[5F>{`TE&h+I9.kEJ#ja:,sWR%Ib%g+F>gzwx;w(mUoWwNn+!G2:MB#LCnxiRz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
