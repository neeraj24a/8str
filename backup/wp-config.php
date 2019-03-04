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
define('DB_NAME', 'homepage');

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
define('AUTH_KEY',         '0r~SK.Y]]i:gRyFVu]U3+:E2($r:e]@8|/UlkC2$)Pr(=p~{Nvv@qB$<*Z1rZ*@i');
define('SECURE_AUTH_KEY',  '|<S2k[D=vs(v7KDQ?d3.=S edJCgjg$]]})@y.C[@%JaC]#PL1Fh/C&$agbqN7e[');
define('LOGGED_IN_KEY',    'x?#Zc9+n$fGe+ MREDGH1P[KwCv:!,@bT MpNTNST!tH@3j3yPh--0*9OYb{G#h-');
define('NONCE_KEY',        '4=;,y%lqZg}]2Sc-(Z%L |-EAJ1EzEG%)8<iQimt8P&AHtOkX,NFKBj$%dRhSU7&');
define('AUTH_SALT',        '{#yl852isW|l[G/L{w/^|+BYn/&1YCWoNSP7V%!*/>nWz~$V.x#`>J{wj$>rFMw3');
define('SECURE_AUTH_SALT', 'Ce&|09[F=8=IW.d,@ZRxb<uVZw@ zP-{>_EOO+!UbE%1saBx scElg`xaf)+P^(!');
define('LOGGED_IN_SALT',   '>;hU#TEG:keR&CHPIc-CdtBni$pt`r!K7g>x:~t^JGh uQ%?zwV6Wd+tuk|.6wcC');
define('NONCE_SALT',       'KMd5x3J1>UgZzg3h3T>a(+hX<z6]wzoa1`u-O:CO^`D,YkO{zCZ*m0;b9(kRwe5o');

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
