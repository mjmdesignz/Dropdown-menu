<?php
/*
Plugin Name: Custom Search Directory
Description: Publishes and searches medics.
Version: 0.0
*/

/***************************

Constants
---------------

WP_MD_BASE_DIR 
Directory path to our plugin folder.
Constant will be used for including our other plugin files into our main plugin file,

WP_MD_BASE_URL
URL to our plugin folder.
Constant will be used for loading script files

***************************/

if(!defined('WP_MD_BASE_DIR')) {
   define('WP_MD_BASE_DIR', dirname(__FILE__));
}
if(!defined('WP_MD_BASE_URL')) {
   define('WP_MD_BASE_URL', plugin_dir_url(__FILE__));
}

/***************************
Language files
----------------
Read more:http://pippinsplugins.com/localizing-and-translating-wordpress-plugins/

***************************
load_plugin_textdomain( 'love_it', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/***************************

Includes
---------------

require / include / require_once

The require() function is identical to include(), except that it handles errors differently. If an error occurs, the include() function generates a warning, but the script will continue execution. The require() generates a fatal error, and the script will stop.

The require_once() statement is identical to require() except PHP will check if the file has already been included, and if so, not include (require) it again.

***************************/
   require_once(WP_MD_BASE_DIR . '/includes/display-functions.php');
   // require_once(WP_MD_BASE_DIR . '/includes/core-functions.php');
   require_once(WP_MD_BASE_DIR . '/includes/script-functions.php');
?>