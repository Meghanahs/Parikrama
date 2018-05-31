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
 * This library extends the CodeIgniter CI_Controller class and creates an application 
 * object allowing use of the HMVC design pattern.
 *
 **/
class CI extends CI_Controller
{
	public static $APP;
	
	public function __construct() {
		
		/* assign the application instance */
		self::$APP = $this;
		
		global $LANG, $CFG;
		
		/* re-assign language and config for modules */
		if ( ! is_a($LANG, 'MX_Lang')) $LANG = new MX_Lang;
		if ( ! is_a($CFG, 'MX_Config')) $CFG = new MX_Config;
		
		parent::__construct();
	}
}

/* create the application object */
new CI;