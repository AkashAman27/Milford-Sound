<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '![@It]h]8j6HrTBp{mLS)*3(Y*&L1%s?M]0r7XZgxmKb7NZGf[Q,7$8>}IB`Gn5]' );
define( 'SECURE_AUTH_KEY',   'oE=>C{xk+ExdPWe v:~ZEF6N(FiWOlS3qFdvg=AYa_YY!:jl/{.{2LO;ST<-)Bip' );
define( 'LOGGED_IN_KEY',     'bz1ywhwl(Z%9auw?]J~!)2`~12p)B)pQjW[JMO$5MjB{;MHTY6BZ+dB Z3s1o7O6' );
define( 'NONCE_KEY',         'eYOX$FJJW}6Qn2LJqbPNpD+UA`TLc$s!f,(2~,Oy -O!MUWoAzB%1Jp7fA@+1rB~' );
define( 'AUTH_SALT',         '<#tYM2/@g6Rk{=l+DMql@~d2<h.hXkZ0Tspm?H_APWq>P~y}sVnKN+QTGO<i{hB2' );
define( 'SECURE_AUTH_SALT',  '!Kztz:yqIbQc%s%(Jle>,>1 |O{l4GxOkik`2+w=&JF)8%)O0F^:t`0z-iO{.;Qy' );
define( 'LOGGED_IN_SALT',    'E|`X>%b=ap x>*(A(IE3w%|u{]j0U9=j#+?Y!ScTsCOz)yvk>y;ni4m+SD[cfi@3' );
define( 'NONCE_SALT',        'NXA3 +%g76UGJIZ!5 23#:ZV3f>fWWc;;oeb:!|=L8s~9`D_0a7`K{%;z-_2;%7N' );
define( 'WP_CACHE_KEY_SALT', '$3OOz.Hc{>Fx9)cBD/&>p-GXH!xT3<i@hmv_M:J>.g.s15,cSDa @}wCvnEcC]*J' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
