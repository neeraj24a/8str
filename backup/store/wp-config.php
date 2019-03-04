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
define('DB_NAME', 'store');

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
define('AUTH_KEY',         'R+1zX{XPQz>vBhl{E]`Nd_W;^/Y{3bw,GUf[r.:CR[7eJ|$J-SKuKF**<<%,C8{s');
define('SECURE_AUTH_KEY',  ']]=DmzUF/{,#RYF<2(mV6CT *A6k<xxEEE|n~#X!W@ %q4no(C@8L~l5.79so)2k');
define('LOGGED_IN_KEY',    'p:%o!-/AH>Y>U(@PKqQh%H3G&4$H)Q.9Cb0;3o7.Aam2)xXN|L+HK j<36O_V)vd');
define('NONCE_KEY',        '!o4.H2AI8uZ2dH;oQy(gM#5WG=4BLxB@/7O:/:=a*ZyV+%JiSlr+UY:(Fp2b=W/u');
define('AUTH_SALT',        '_X+c)y::cjb}Y]>aleSByB<kX}=U<g]+dB2$g.cjOndmo40sgR7K`>yF#_;@D<*p');
define('SECURE_AUTH_SALT', 'QznE{*bu]@5e{?@&X$F>Bu$%@r@Im>YE_nHemHS4dqp Z`:]P;b1f4{}HOo3r?C5');
define('LOGGED_IN_SALT',   'M4eJy{5S|JQO(fi!da8Q$m5.2FPasvv+LjA7jC}WHlJd_a7i^mcH~16)M^g!pQBl');
define('NONCE_SALT',       '6uhvxsSO7Ll!~{(/v-~%anKsTh)2=ae|%jo*riM s|=L9P9]N$#+C.Hqj@g=aHVX');

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
