<?php
/********************************************************/
/* Copyright (C) 2009 Tom Hartung, All Rights Reserved. */
/********************************************************/

/**
 * @version     $Id: StoreInDatabase.php,v 1.13 2009/05/21 19:47:07 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2009 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php .
 */

/**
 * ================================================
 * This class runs outside of the joomla! framework
 * ================================================
 * Therefore we define _JEXEC (rather than check to see if it's defined)
 */
define( '_JEXEC', 1 );
define( 'JPATH_BASE', dirname(__FILE__) );
define( 'JPATH_PLATFORM', dirname(__FILE__));
//print "<p>JPATH_BASE = '" . JPATH_BASE . "'</p>\n";
//print "<p>JPATH_PLATFORM = '" . JPATH_PLATFORM . "'</p>\n";

if ( !defined('DIRECTORY_SEPARATOR') )
{
	define( 'DIRECTORY_SEPARATOR', "/" );
}
define('DS', DIRECTORY_SEPARATOR);
//
// Note: must link ../joomla/configuration.php ../joomla/libraries/ and ../joomla/includes/
//       to customizations
//
require_once "../../../configuration.php";
require_once "../../../libraries/loader.php";
require_once "../../../libraries/joomla/base/object.php";
require_once "../../../libraries/joomla/factory.php";
require_once "../../../libraries/joomla/database/database.php";
require_once "../../../libraries/joomla/database/database/mysql.php";
require_once "../../../libraries/joomla/database/table.php";
require_once "../../../libraries/joomla/error/error.php";
require_once "../../../libraries/joomla/environment/request.php";
require_once "../../../libraries/joomla/filter/filterinput.php";
require_once "../../../libraries/joomla/methods.php";
require_once "../../../libraries/joomla/user/user.php";

require_once ( '../classes/JoomooSitestyleColors.php' );
require_once ( '../classes/JoomooSitestyleLimits.php' );
require_once ( '../tables/joomoositestyle.php' );

$saveParms = new StoreInDatabase();
$saveParms->storeInDatabase();

/**
 * This class runs outside of the joomla! framework
 *
 *
 */
class StoreInDatabase
{
	/**
	 * id of row in database for this user
	 * equals 0 if we are not saving parms in db
	 * @access private
	 * @var int
	 */
	private $_id = 0;
	/**
	 * array of configuration options used to set up DB connection
	 * @access private
	 */
	private $_options;
	/**
	 * JDatabase object used to connect with DB
	 * @access private
	 */
	private $_db;
	/**
	 * stdClass object with data to store
	 * @access private
	 */
	private $_params;
	/**
	 * true if we are saving these by user's ip address else false
	 * @access private
	 */
	private $_save_by_ip;
	/**
	 * success or error message returned to requestor
	 * @access private
	 */
	private $_message;

	/**
	 * constructor
	 * @access public
	 */
	public function __construct()
	{
		//	print "Hello from StoreInDatabase::__construct()<br />\n";

		isset($_POST['id']) ? $id = htmlspecialchars($_POST['id']) : $id = '';

		if ( is_numeric($id) )
		{
			$this->_id = $id;
		}

		/*
		 * Read configuration information and establish connection to DB
		 */
		JFactory::getConfig( "../../../configuration.php" );
		$config = new JConfig();
		$host = $config->host;
		$user = $config->user;
		$password = $config->password;
		$db = $config->db;
		$dbprefix = $config->dbprefix;

		//	print "host = " . $host . "<br />\n";
		//	print "user = " . $user . "<br />\n";
		//	print "password = " . $password . "<br />\n";
		//	print "db = " . $db . "<br />\n";
		//	print "dbprefix = " . $dbprefix . "<br />\n";

		$this->_options = array (
			'host'     => $host,
			'user'     => $user,
			'password' => $password,
			'database' => $db,
			'prefix'   => $dbprefix,
		);
//		$this->_db = new JDatabaseMySQL( $this->_options );
		$this->_db = JFactory::getDbo();
	}
	/**
	 * returns database object instantiated in constructor
	 * @access private
	 * @return db JDatabaseMySQL object
	 */
	private function &_getDb()
	{
		// print "Hello from StoreInDatabase::_getDb();<br />\n";
		return $this->_db;
	}

	/**
	 * driver function to save parameters
	 * @access public
	 * @return void
	 */
	public function storeInDatabase( )
	{
		//	print "Hello from StoreInDatabase::storeInDatabase()<br />\n";
		//	$this->_printAllPostVariables();

		$this->_setData();
		$storedOk = $this->_storeData();

		if ( $storedOk )
		{
			print $this->_message . ' saved OK.<br />';
		}
		else
		{
			$this->_message = $this->_db->getError();
			print "Error storing data: " . $this->_message . "<br />\n";
		}

		return $storedOk;
	}
	/**
	 * set data (stdClass object) to values set in POST variables
	 * @access private
	 * @return void
	 */
	private function _setData( )
	{
		// print "Hello from StoreInDatabase::_setData()<br />\n";
		$this->_params = new stdClass();
		$this->_params->id = $this->_id;

		isset($_POST['save_by_ip']) ?
			$this->_save_by_ip = htmlspecialchars($_POST['save_by_ip']) :
			$this->_save_by_ip = FALSE;

		$this->_params->ip_address = '';
		if ( $this->_save_by_ip )
		{
			if ( isset($_POST['ip_address']) )
			{
				$this->_params->ip_address = htmlspecialchars($_POST['ip_address']);
			}
		}

		$this->_message = 'Value for ';

		$this->_params->background = '';
		$background = htmlspecialchars(JRequest::getVar('background'));
		if ( 0 < strlen($background) )
		{
			$this->_params->background = $background;
			$this->_message .= 'background (' . $background . ') ';
		}

		$this->_params->border_color_name = '';
		$border_color_name = htmlspecialchars(JRequest::getVar('border_color_name'));
		if ( 0 < strlen($border_color_name) )
		{
			$this->_params->border_color_name = $border_color_name;
			$this->_message .= 'border color (' . $border_color_name . ') ';
		}

		$this->_params->border_style = '';
		$border_style = htmlspecialchars(JRequest::getVar('border_style'));
		if ( 0 < strlen($border_style) )
		{
			$this->_params->border_style = $border_style;
			$this->_message .= 'border style (' . $border_style . ') ';
		}

		$this->_params->border_width = '';
		$new_border_width = htmlspecialchars(JRequest::getVar('border_width'));
		if ( 0 < strlen($new_border_width) )
		{
			$new_border_width = (int) $new_border_width;
			if ( JoomooSitestyleLimits::$minimum_border_width <= $new_border_width &&
			     $new_border_width <= JoomooSitestyleLimits::$maximum_border_width   )
			{
				$this->_params->border_width = $new_border_width;
				$this->_message .= 'border width (' . $new_border_width . ') ';
			}
		}

		$this->_params->font_size = '';
		$new_font_size = htmlspecialchars(JRequest::getVar('font_size'));
		if ( 0 < strlen($new_font_size) )
		{
			$new_font_size = (int) $new_font_size;
			if ( JoomooSitestyleLimits::$minimum_font_size <= $new_font_size &&
			     $new_font_size <= JoomooSitestyleLimits::$maximum_font_size   )
			{
				$this->_params->font_size = $new_font_size;
				$this->_message .= 'font size (' . $new_font_size . ') ';
			}
		}

		//	print "<br />\n";
		//	print "StoreInDatabase::_setData(): storing data for this->_id   = \"" . $this->_id . "\"<br />";
		//	print "this->_params->id = '" . $this->_params->id . "'<br />\n";
		//	print "this->_params->background = '" . $this->_params->background . "'<br />\n";
		//	print "this->_params->border_color_name = '" . $this->_params->border_color_name . "'<br />\n";
		//	print "this->_params->border_style = '" . $this->_params->border_style . "'<br />\n";
		//	print "this->_params->border_width = '" . $this->_params->border_width . "'<br />\n";
		//	print "this->_params->font_size = '" . $this->_params->font_size . "'<br />\n";
	}

	/**
	 * store new value(s) for template parameter(s)
	 * @access private
	 * @return True if successful, else False
	 */
	private function _storeData( )
	{
		//	print "Hello from StoreInDatabase::_storeData()<br />\n";

		$db =& $this->_getDb();
		$table = new TableJoomooSitestyle( $db );

		// $tableClass = get_class( $table );
		// print "In StoreInDatabase::_storeData(): tableClass = \"$tableClass\"<br />\n";

		if ( ! $table->bind($this->_params) )
		{
			print "StoreInDatabase::_storeData - bind error: " . $table->getError() . "<br />\n";
			$db->setError( $table->getError() );
			return FALSE;
		}
		// else
		// {
		// 	print "StoreInDatabase::_storeData(): table->bind() ran OK.<br />\n";
		// }

		if ( ! $table->check($this->_save_by_ip) )
		{
			print "StoreInDatabase::_storeData - check error: " . $table->getError() . "<br />\n";
			$db->setError( $table->getError() );
			return FALSE;
		}
		// else
		// {
		// 	print "StoreInDatabase::_storeData(): table->check() ran OK.<br />\n";
		// }

		if ( ! $table->store() )
		{
			print "StoreInDatabase::_storeData - store error: " . $table->getError() . "<br />\n";
			$db->setError( $table->getError() );
			return FALSE;
		}
		//	else
		//	{
		//		print "StoreInDatabase::_storeData(): table->store() ran OK.<br />\n";
		//	}

		// $this->_row =& $table;

		return TRUE;
	}

	/**
	 * print all post variables (useful when debugging)
	 * @access private
	 * @return void
	 */
	private function _printAllPostVariables( )
	{
		print "<br />\n";
		print "<h3>StoreInDatabase::_printAllPostVariables()</h3>\n";
		print "<p style=\"margin-left: 16px;\">\n";

		if ( is_array($_POST) )
		{
			if ( 0 < count($_POST) )
			{
				foreach ( $_POST as $name => $value )
				{
				   print "post variables: _POST[$name] = $value<br />\n";
				}
				print " <br />\n";
				print " (End of list of post variables.)\n";
			}
			else
			{
				print "(There were no POST variables in the request.)\n";
				return;
			}
		}
		else
		{
			print "(Unable to reference the _POST array in the request.)\n";
			return;
		}

		print "</p>\n";
	}
}
?>
