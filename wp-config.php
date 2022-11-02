<?php
/**
 * This config file is yours to hack on. It will work out of the box on Pantheon
 * but you may find there are a lot of neat tricks to be used here.
 *
 * See our documentation for more details:
 *
 * https://pantheon.io/docs
 */

/**
 * Pantheon platform settings. Everything you need should already be set.
 */
if (file_exists(dirname(__FILE__) . '/wp-config-pantheon.php') && isset($_ENV['PANTHEON_ENVIRONMENT'])) {
	require_once(dirname(__FILE__) . '/wp-config-pantheon.php');

/**
 * Local configuration information.
 *
 * If you are working in a local/desktop development environment and want to
 * keep your config separate, we recommend using a 'wp-config-local.php' file,
 * which you should also make sure you .gitignore.
 */
} elseif (file_exists(dirname(__FILE__) . '/wp-config-local.php') && !isset($_ENV['PANTHEON_ENVIRONMENT'])){
	# IMPORTANT: ensure your local config does not include wp-settings.php
	require_once(dirname(__FILE__) . '/wp-config-local.php');

/**
 * This block will be executed if you are NOT running on Pantheon and have NO
 * wp-config-local.php. Insert alternate config here if necessary.
 *
 * If you are only running on Pantheon, you can ignore this block.
 */
} else {
  // ** Database settings - You can get this info from your web host ** //
  /** The name of the database for WordPress */
  define( 'DB_NAME', 'innovationtracker' );

  /** Database username */
  define( 'DB_USER', 'mysqluser' );

  /** Database password */
  define( 'DB_PASSWORD', 'tim$SPW4MS' );

  /** Database hostname */
  define( 'DB_HOST', 'localhost' );

  /** Database charset to use in creating database tables. */
  define( 'DB_CHARSET', 'utf8' );

  /** The database collate type. Don't change this if in doubt. */
  define( 'DB_COLLATE', '' );

  define('AUTH_KEY',         'f5$VCeIJQIPtAAh`hiYJ_bxMBC #dE72LeU5 f]|+6V,IXnVlj2$5l5;}*h=Y#gn');
  define('SECURE_AUTH_KEY',  '|wy$a}7s<7Q)h*,HY2Jy}+%ka)%+>+:r-?s:&Q|,6gYY:o5|5Mz?4Y-CuXlmg9r0');
  define('LOGGED_IN_KEY',    '.&}usqYALfY&-73MhoNNEv=O| dLf:N;M:!GRqeoi.pPr(v4HP+H^w+5Kw-(6WQF');
  define('NONCE_KEY',        'aJnlw0?a&L|%f3ZIyihTCP79KiZtic-<,j`K%|U2-z#x1,1c}2zHVf2!fqxiJze(');
  define('AUTH_SALT',        'C&UabYe/v$<gkv$V#KCdtVbaCIrSJe|z^o$jLDbzQZv$1gETGm[cG(sNYXe{&6Q)');
  define('SECURE_AUTH_SALT', '~9bgV)5]iy]U,5S&{Jd+y|/dbKWuRp8{qYBsPZz#@Y$PmCbq9D|2&x7]?|Cwn>x`');
  define('LOGGED_IN_SALT',   'ZJA`dfV1r2(KKDTcK~2~g&n]JR{_kL:HP3yRZAp#o5{l*)!>}bOuH<IB:6yu0Vm[');
  define('NONCE_SALT',       'b`(gPeT<-@7o#ZJq||4?r,JA8>|j;`!pia^U2Hr-WGpFJjm$J2hrNe(**4$.,Q;J');
}


/** Standard wp-config.php stuff from here on down. **/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * You may want to examine $_ENV['PANTHEON_ENVIRONMENT'] to set this to be
 * "true" in dev, but false in test and live.
 */
if ( ! defined( 'WP_DEBUG' ) ) {
  define( 'WP_DEBUG', true );
  define( 'WP_DEBUG_LOG', true );
  define( 'WP_DEBUG_DISPLAY', true );
  define( 'WP_CACHE', false );
}

/* That's all, stop editing! Happy Pressing. */




/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
