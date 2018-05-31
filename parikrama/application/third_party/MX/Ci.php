<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load MX core classes */
require_once dirname(__FILE__).'/Lang.php';
require_once dirname(__FILE__).'/Config.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library creates a CI class which allows the use of modules in an application.
 *
 * Install this file as application/third_party/MX/Ci.php
 *
 **/
class CI
{
	public static $APP;
	
	public function __construct() {
		
		/* assign the application instance */
		self::$APP = CI_Controller::get_instance();
		
		global $LANG, $CFG;
		
		/* re-assign language and config for modules */
		if ( ! is_a($LANG, 'MX_Lang')) $LANG = new MX_Lang;
		if ( ! is_a($CFG, 'MX_Config')) $CFG = new MX_Config;
	}
}

/* create the application object */
new CI;