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
define( 'DB_NAME', 'company_site2' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'q{]H%dc.SfWdJ8&`g|vY<IVB.en]3{k79Uc0jUi=G!rf=`K!&q(qkf}[x%n~B5h7' );
define( 'SECURE_AUTH_KEY',  'C6Op1;9:.)J>rf*U?~_~eC`fO<dCJaVBi|,(,)*ShrQDm5hzu+@WC6YGGKfEd{U,' );
define( 'LOGGED_IN_KEY',    'f.ij7vBL51ee&2{bhKE]th[2txJBW2][~UiAbv??&V&ZY ZkZoe^9=r46~}GM7%&' );
define( 'NONCE_KEY',        '?7QoURGq[2{*Q@W:~}K<orAlS5>Y=B( _T6kOYg.JSH16T AHqUIOWkTMXFc]E=#' );
define( 'AUTH_SALT',        'Qye{Cdl~(&~V2+J*xGU/f3falX&f^tLV8PTi|m_{Jf1TRAJONZ ;C<^Z(}9OG?={' );
define( 'SECURE_AUTH_SALT', '})GbxJ&A%[X;c7qDCdcAn_ICQ`3{hugk6i9//%QPH@K ?O-H%_U`fV5@FPl84T[A' );
define( 'LOGGED_IN_SALT',   'ju)1CHA PEb,]k|~Mwp1/&tW*h*`T(?}II.3!jWF=7Ga>%xC`D}~_0N[{O<u|E8P' );
define( 'NONCE_SALT',       'ad6fFHaUN gj*#b(%/V5u,MgzmF>LeIR(@j,p]enjP|mchDkwb@^UZ#W4ZUaoL53' );

/**#@-*/

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
