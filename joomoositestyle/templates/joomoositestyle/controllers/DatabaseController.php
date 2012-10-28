<?php
/**
 * @version     $Id: DatabaseController.php,v 1.11 2009/05/20 20:13:00 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  Joomoogallery
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/**
 * JoomooSitestyle Template Controller - saves/retrieves params in/from DB
 */
class JoomooSitestyleDatabaseController
{
	/**
	 * Are we saving the params in the database?
	 * True if user logged in or we are saving by ip address, else False
	 * @access public
	 * @var boolean True: saving params in DB
	 */
	public $usingDb = False;
	/**
	 * id of row in jos_joomoositestyle table containing values for this user
	 * @access public
	 * @var int primary key to jos_joomoositestyle table
	 */
	public $id = 0;

	/**
	 * background, eg. 'dark_blue' - value from DB for this user_id/ip_address
	 * @access public
	 * @var string
	 */
	public $background  = '';
	/**
	 * border color name, eg. 'maroon' - value from DB for this user_id/ip_address
	 * @access public
	 * @var string
	 */
	public $border_color_name = '';
	/**
	 * border style, eg. 'solid' - value from DB for this user_id/ip_address
	 * @access public
	 * @var string
	 */
	public $border_style = '';
	/**
	 * border width, eg. 7 - value from DB for this user_id/ip_address
	 * @access public
	 * @var int
	 */
	public $border_width = 0;
	/**
	 * font size as a percentage, eg. 85 - value from DB for this user_id/ip_address
	 * @access public
	 * @var int
	 */
	public $font_size = 0;

	/**
	 * default background, eg. 'dark_blue' - set values in back end, index.php sets it here
	 * @access private
	 * @var string
	 */
	private $_default_background  = '';
	/**
	 * default border color name, eg. 'maroon' - set values in back end, index.php sets it here
	 * @access private
	 * @var string
	 */
	private $_default_border_color_name = '';
	/**
	 * default border style, eg. 'solid' - set values in back end, index.php sets it here
	 * @access private
	 * @var string
	 */
	private $_default_border_style = '';
	/**
	 * default border width, eg. 7 - set values in back end, index.php sets it here
	 * @access private
	 * @var int
	 */
	private $_default_border_width = 0;
	/**
	 * default font size as a percentage, eg. 85 - set values in back end, index.php sets it here
	 * @access private
	 * @var int
	 */
	private $_default_font_size = 0;

	/**
	 * JUser object corresponding to current visitor
	 * Try to use other member variables rather than this one (to ease conversion to another CMS)
	 * @access private
	 * @var JUser
	 */
	private $_juserObject;
	/**
	 * user id of logged in user (0 if not logged in)
	 * @access private
	 * @var int
	 */
	private $_user_id = 0;
	/**
	 * True if we want to save anonymous users' values in db by ip address
	 * @access private
	 * @var boolean save by ip flag
	 */
	private $_save_by_ip = 0;
	/**
	 * ip address if saving by ip is enabled for non logged in users
	 * @access private
	 * @var string ip address
	 */
	private $_ip_address = '';

	/**
	 * This component uses one model: JoomooSitestyleModelJoomooSitestyle
	 * model supporting access to jos_joomoositestyle table in DB
	 * @access private
	 * @var instance of JoomooSitestyleModelJoomooSitestyle
	 */
	private $_paramsModel = null;

	/**
	 * Constructor: set the model paths
	 * @access public
	 */
	public function __construct( $save_by_ip=null )
	{
		// print "Hello from JoomooSitestyleDatabaseController::__construct()<br />\n";

		if ( $save_by_ip == null )
		{
			$document = & JFactory::getDocument();
			$this->_save_by_ip = $document->params->get('save_by_ip');
		}
		else
		{
			$this->_save_by_ip = $save_by_ip;
		}
		$this->_juserObject = JFactory::getUser();

		if ( isset($this->_juserObject->id) && $this->_juserObject->id != 0 )
		{
		//	$isLoggedIn = True;
			$this->_user_id    = $this->_juserObject->id;
			$this->_ip_address = "";
			$this->usingDb = True;
		}
		else
		{
		//	$isLoggedIn = False;
			$this->_user_id = 0;
			if ( $this->_save_by_ip )
			{
				$this->_ip_address = $_SERVER['REMOTE_ADDR'];
				$this->usingDb = True;
			}
			else
			{
				$this->_ip_address = '';
				$this->usingDb = False;
			}
		}
	}

	/**
	 * returns the ip address, which is set only if it needs to be
	 * @access public
	 */
	public function getIpAddress()
	{
		return $this->_ip_address;
	}

	/**
	 * creates the params database model used by the template
	 * @access public
	 */
	public function createParamsModel()
	{
		$this->_paramsModel = new JoomooSitestyleDatabaseModel();
	}

	/**
	 * Sets default values for the parameters; site admins. set these values in the back end
	 * @access public
	 */
	public function setDefaults(
		$default_background,
		$default_border_color_name,
		$default_border_style,
		$default_border_width,
		$default_font_size
	)
	{
		$this->_default_background = $default_background;
		$this->_default_border_color_name = $default_border_color_name;
		$this->_default_border_style = $default_border_style;
		$this->_default_border_width = $default_border_width;
		$this->_default_font_size = $default_font_size;
	}

	/**
	 * sets values for params using the database, cookie, or by using the defaults set in the back end
	 * if we are using the db and it has no row yet, creates a new row for user_id or ip_address
	 * @access public
	 * @return void
	 */
	public function getJoomooSitestyleParams()
	{
		// print "Hello from JoomooSitestyleDatabaseController::getJoomooSitestyleParams() in file DatabaseController.php<br />\n";
		// $tableName = $this->_paramsModel->getTableName();
		// print "getJoomooSitestyleParams: = tableName " . $tableName . "<br />\n";

		$this->_paramsModel->setUserId( $this->_user_id );
		$this->_paramsModel->setIpAddress( $this->_ip_address );
		$data = $this->_paramsModel->getRow();

		// print "getJoomooSitestyleParams: running print_r on data returned:<br />print_r output -->'\n";
		// print_r ( $data );
		// print "'<-- end of print_r output<br />\n";

		if ( ! isset($data->id) || $data->id == 0 )
		{
			// print "getJoomooSitestyleParams: data->id is NOT defined<br />\n";
			$dataFound = FALSE;
			if ( $this->_save_by_ip )
			{
				// print "getJoomooSitestyleParams: saving by ip is enabled but no row is present in db yet<br />\n";
				// print "Creating new row for ip_address<br />\n";
				$data = new stdClass();
				$data->id = 0;        // create new row with ip_address as key
				$data->user_id = 0;
				$data->save_by_ip = $this->_save_by_ip;
				$data->ip_address = $this->_ip_address;
				$data->background = $this->_default_background;
				$data->border_color_name = $this->_default_border_color_name;
				$data->border_style = $this->_default_border_style;
				$data->border_width = $this->_default_border_width;
				$data->font_size = $this->_default_font_size;
				$storedOk = $this->_paramsModel->store($data);
				if ( $storedOk )
				{
					// print "New row (for ip_address) stored OK!<br />\n";
					$dataFound = TRUE;
				}
				else
				{
					// print "Error saving new row (for ip_address): " . $this->_paramsModel->getError() . "!<br />\n";
					$dataFound = FALSE;
				}
			}
			else
			{
				$joomoositestyle_params = $_COOKIE[JOOMOO_SITESTYLE_COOKIE_NAME];
				if ( 0 < strlen($joomoositestyle_params) )
				{
					//	print "Creating new row based on row saved in cookie<br />\n";
					$delimiter = JOOMOO_SITESTYLE_COOKIE_DELIMITER;
					$values = explode( $delimiter, $joomoositestyle_params );
					$data = new stdClass();
					$data->id = 0;                      // create new row with user_id as key
					$data->user_id = $this->_juserObject->id;
					$data->background = $values[0];
					$data->border_color_name = $values[1];
					$data->border_style = $values[2];
					$data->border_width = $values[3];
					$data->font_size = $values[4];
					$dataFound = TRUE;
				}
			}
			if ( ! $dataFound )
			{
				//	print "Creating new row based on defaults<br />\n";
				$data = new stdClass();
				$data->id = 0;                      // create new row with user_id as key
				$data->user_id = $this->_user_id;
				$data->ip_address = $this->_ip_address;
				$data->background = $this->_default_background;
				$data->border_color_name = $this->_default_border_color_name;
				$data->border_style = $this->_default_border_style;
				$data->border_width = $this->_default_border_width;
				$data->font_size = $this->_default_font_size;
			}
		}

		$this->id = $data->id;
		$this->background = $data->background;
		$this->border_color_name = $data->border_color_name;
		$this->border_style = $data->border_style;
		$this->border_width = $data->border_width;
		$this->font_size = $data->font_size;
	}
}
