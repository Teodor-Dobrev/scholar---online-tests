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
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '[Y59;(bZ3FRo#x/ph0f5ds7zn2LBB=6j>hKqL}@cSD.i:S[nV+n3t!&{H/UW8i|X');
define('SECURE_AUTH_KEY',  'Cs,BLc:}3`MX+=T8*dtFsx&;A z^)DDz4^h.y,`EokTsx_w@U;EB:=;H]TTowr;6');
define('LOGGED_IN_KEY',    'KjBHW+w*+-R/:j1,ia9SjzhhL4J,.yeRf*SpQZ&8:_a9jiHjIutZWPaqm`:[u(_V');
define('NONCE_KEY',        'F2?H^IVY9wnWqQphD4XjjA}*6#_4]ObZZcaV}c!dK[$=NY>0?&{b, ^J_o}/MY&(');
define('AUTH_SALT',        '5G]M=NwIR;(fc=P;}u1=&<Xh!EmB>!q1$yA;&@;,6lncG[m95|.Xg1(:;BgH%kVG');
define('SECURE_AUTH_SALT', '7%S,TjcBhp%iin%G]t_tJi3I5E-ZL.3;%YZ#frro^>C5;@Y^PDaDbk< +_bhE_:~');
define('LOGGED_IN_SALT',   '1AL<PtBC)AUx^3.yK#{bWn[@4UnC*muonosTE3q)q,X&T7~%d%& M+[wPDyy]e,$');
define('NONCE_SALT',       '.Xj]^) @tYoS0SstR)|w`zg0B~$c237?v-JH6DI}5eEP%uAGt$Q`b! {{>Jceb~`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sc1_';

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
