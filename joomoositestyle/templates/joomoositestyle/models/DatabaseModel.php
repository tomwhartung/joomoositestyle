<?php
/**
 * @version     $Id: DatabaseModel.php,v 1.2 2009/05/02 00:01:31 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * DB model for the JoomooSitestyle template
 */
class JoomooSitestyleDatabaseModel extends JModel
{
	/**
	 * name of table that this object supports
	 * @access private
	 * @var string
	 */
	private $_tableName = '';
	/**
	 * ID of current row in table (or 0)
	 * @access private
	 */
	private $_id = 0;
	/**
	 * Current row in table (or null)
	 * @access private
	 */
	private $_row = null;
	/**
	 * user id of current user (0 if user not logged in)
	 * @access private
	 * @var int foreign key to jos_users table
	 */
	private $_userId = 0;
	/**
	 * ip address of non-logged in user
	 * @access private
	 * @var string
	 */
	private $_ip_address;

	/**
	 * Overridden constructor
	 * @access public
	 */
	public function __construct()
	{
		global $mainframe;

		parent::__construct();

		// print "Hello from JoomooSitestyleDatabaseModel::__construct()<br />\n";
		// print "This is file joomoositestyle/models/DatabaseModel.php<br />\n";

		$this->_tableName = "#__joomoositestyle";
	}

	/**
	 * Retrieves name of this component's table in DB
	 * @return string containing name of DB for this component
	 */
	public function getTableName()
	{
		// print "Hello from JoomooSitestyleDatabaseModel::getTableName()<br />\n";
		// print "returning this->_tableName = \"$this->_tableName\" <br />\n";

		return $this->_tableName;
	}
	/**
	 * Sets ID
	 * @access public
	 * @return void
	 */
	public function setId( $id=0 )
	{
		$this->_id = $id;
	}
	/**
	 * Gets ID
	 * @access public
	 * @return integer ID of current record
	 */
	public function getId ()
	{
		return $this->_id;
	}
 
	/** 
	 * Sets user id of current user
	 * @access public
	 * @return void
	 */  
	public function setUserId( $userId=0 )
	{   
		$this->_userId = $userId;
	}   
	/** 
	 * Gets user id of current user
	 * @access public
	 * @return integer ID of current user
	 */  
	public function getUserId ()
	{   
		return $this->_userId;
	}
	/** 
	 * Sets ip address of current user
	 * @access public
	 * @return void
	 */  
	public function setIpAddress( $ip_address='' )
	{   
		$this->_ip_address = $ip_address;
	}   
	/** 
	 * Gets ip address of current user
	 * @access public
	 * @return string ip address
	 */  
	public function getIpAddress ()
	{   
		return $this->_ip_address;
	}

	/**
	 * Method to store a record - copied from tutorial
	 * @access public
	 * @return boolean True on success else false
	 */
	public function store( $data )
	{
		// print "Hello from JoomooSitestyleDatabaseModel::store()<br />\n";

		//
		// WEIRDO HACK ALERT!!
		// -------------------
		// For some reason in this case we have to remove the prefix from the table name.
		// OMFG It took me HOURS to figure out this problem - had to hack the source and everything!
		// I guess maybe it has something to do with trying to run these methods from the template,
		// maybe before everything is set up?
		//
		// $this->_row =& $this->getTable( $this->_tableName );
		// print "this->_row 1:<br />\n";
		// print_r ( $this->_row );
		// print "<br />\n";
		// $this->_row =& $this->getTable( 'joomoositestyle' );

		$tableNameNoUnderscores = preg_replace( '&^[#_]*&', '', $this->_tableName );
		$this->_row =& $this->getTable( $tableNameNoUnderscores );

		// print "tableNameNoUnderscores = " .  $tableNameNoUnderscores . '<br />';
		// print "this->_row 2:<br />\n";
		// print_r ( $this->_row );
		// print "<br />\n";

		if ( !$this->_row->bind($data) )            // Bind the form fields to the table
		{
			$this->setError($this->_row->getError());
			return false;
		}

		if ( !$this->_row->check( $data->save_by_ip ) )                // Make sure the data is valid
		{
			$this->setError($this->_row->getError());
			return false;
		}

		if ( !$this->_row->store() )                // Store the table to the database
		{
			$this->setError($this->_row->getError());
			return false;
		}

		$this->_id = $this->_row->id;

		return true;
	}

	/**
	 * get row of data for either current user_id or current ip_address
	 * @access public
	 * @return row of data
	 */
	public function getRow()
	{
		// print "Hello from JoomooSitestyleDatabaseModel::getRow()<br />\n";

		if ( $this->_userId == 0 )
		{
			$data = $this->getRowForIpAddress();
		}
		else
		{
			$data = $this->getRowForUserId();
		}

		// print "getRow: running print_r on data returned:<br />print_r output -->'\n";
		// print_r ( $data );
		// print "'<-- end of print_r output<br />\n";

		return $data;
	}

	/**
	 * get row of data for specified user id or $this->_userId
	 * @access public
	 * @return row of data
	 */
	public function getRowForUserId( $userId = null )
	{
		// print "Hello from JoomooSitestyleDatabaseModel::getRowForUserId()<br />\n";

		if ( $userId == null )
		{
			$userId = $this->_userId;
		}

		$db =& $this->getDBO();
		$query = 'SELECT * FROM ' . $db->nameQuote($this->_tableName) .
		          ' WHERE ' . $db->nameQuote('user_id') . ' = ' . $userId . ';';

		// print( "getRowForUserId: query = $query<br />\n" );

		$db->setQuery( $query );
		$this->_row = $db->loadObject();

		return $this->_row;
	}
	/**
	 * get row of data for specified ip address or $this->_ip_address
	 * @access public
	 * @return row of data
	 */
	public function getRowForIpAddress( $ip_address = null )
	{
		// print "Hello from JoomooSitestyleDatabaseModel::getRowForIpAddress()<br />\n";

		if ( $ip_address == null )
		{
			$ip_address = $this->_ip_address;
		}

		$db =& $this->getDBO();
		$query = 'SELECT * FROM ' . $db->nameQuote($this->_tableName) .
		          ' WHERE ' . $db->nameQuote('ip_address') . ' = ' . $db->Quote($ip_address) . ';';

		// print( "getRowForIpAddress: query = $query<br />\n" );

		$db->setQuery( $query );
		$this->_row = $db->loadObject();

		return $this->_row;
	}
}
?>
