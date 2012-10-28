<?php
/**
 * @version     $Id: joomoositestyle.php,v 1.3 2009/05/21 21:25:58 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @link        http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:components/
 * @subpackage  JoomooSitestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * JoomooSitestyle Model for com_joomoositestyle component
 */
class JoomooSitestyleModelJoomooSitestyle extends JoomoobaseModelJoomoobaseDb
{
	/**
	 * Overridden constructor
	 * @access protected
	 */
	public function __construct()
	{
		parent::__construct();

		// print "Hello from JoomooSitestyleModelJoomooSitestyle::__construct()<br />\n";

		$this->_tableName = "#__joomoositestyle";
	}

	/**
	 * create lists array containing ordering and filtering lists
	 * @access public
	 * @return array lists to use when outputing HTML to display the list of rows
	 */
	public function getLists( )
	{
		// print "Hello from JoomooSitestyleModelJoomooSitestyle::getLists()<br />\n";
		// print "getLists before: count(this->_lists) = " . count($this->_lists) . "<br />\n";

		if ( count($this->_lists) == 0 )
		{
			parent::getLists();
		//	print "getLists after: count(this->_lists) = " . count($this->_lists) . "<br />\n";
		}

		return $this->_lists;
	}
	/**
	 * builds order by clause for _listquery (implements ordering)
	 * @access protected
	 * @return: order by clause for query
	 */
	protected function _getOrderByClause( $orderByColumns )
	{
		//	print "Hello from JoomooSitestyleModelJoomooSitestyle::_getOrderByClause()<br />\n";

		$default_filter_order = 'id';
		$orderByClause = parent::_getOrderByClause( $orderByColumns, $default_filter_order );

		//	print "JoomooSitestyleModelJoomooSitestyle::_getOrderByClause: returning orderByClause = \"$orderByClause\"<br />\n";

		return $orderByClause;
	}

	/**
	 * builds order by clause for _listquery (implements ordering) - from p. 230 of Mastering book
	 * @access protected
	 * @return: order by clause for query
	 */
	protected function _buildQueryOrderBy()
	{
		//	print "Hello from JoomooSitestyleModelJoomooSitestyle::_buildQueryOrderBy()<br />\n";
		//
		// array of fields that can be sorted:
		//
		$orderByColumns = array( 'id',
			'user_id',
			'ip_address',
			'background',
			'border_color_name',
			'border_style',
			'border_width',
			'font_size',
			'timestamp'
		);
		$orderByClause = $this->_getOrderByClause( $orderByColumns );

		//	print "_buildQueryOrderBy: returning orderByClause = \"$orderByClause\"<br />\n";
		return $orderByClause;
	}
}
?>
