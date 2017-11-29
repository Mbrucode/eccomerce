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
define('DB_NAME', 'apdrinkss');

/** MySQL database username */
define('DB_USER', 'root');

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
define('AUTH_KEY',         'Fu)|$rjom|%,S*S8>la,GaJQ`|!M$-TboBLp@D/TO`.vJ`_^2U9X,R3J5#,O6p=V');
define('SECURE_AUTH_KEY',  'M4Z=@~StqMY_IIl~!c>OLJGvB*196V3v@*MJA?H@uf6tb<JxS(TVMwO~}a^3{MN1');
define('LOGGED_IN_KEY',    'YluHi<M$SN]zG~U3)jgJC~)vx)1>xOlcb@ WtxcVDEQg!rNM]7J;F%kk(zrlU]~)');
define('NONCE_KEY',        '<]<X_zxmo-6WDs]/yubP!225z/mMcUQqLv.8fMF/gx;J*aJqP?24VLBmOr*}a.$F');
define('AUTH_SALT',        'zCn~evLqG6{nP<OsOZwCrR}J^1|$c~xm`t301J31kM&4j+O=@[Bx4?Z}DLnC@@iG');
define('SECURE_AUTH_SALT', 'oichQo<v]Wglb3!TlK^2(8yeT{p|n>RWjl9#!>^p|hDL:W4yGpb$6W7`Lz]=,<74');
define('LOGGED_IN_SALT',   '5o8|W2.:g3$]rP]uqm5Wv^Q/k3d{8ie&Ja>rba={()K2-Tf<wmnLsKBHcB[BsMu:');
define('NONCE_SALT',       ',6e<PD&p1z(31&#G5QWxcfY9a?O3dEs{Zk@_I Y,)vYo%|-c#peOK>sbyI$JF$x}');
define('FS_METHOD','direct');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'apd_';

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
