<?php
/**
 * @version     $Id: joomoositestyle.php,v 1.6 2009/05/05 15:03:16 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  Joomoogallery
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Joomla class interface to #__joomoositestyle table
 * Defines column names and database methods for the joomoositestyle table
 */
class TableJoomooSitestyle extends JTable
{
	/**
	 */
	/**
	 * @var int Primary Key
	 */
	public $id = null;
	/**
	 * @var int user id: foreign key to jos_users table
	 */
	public $user_id = null;
	/**
	 * @var string user's ip address
	 */
	public $ip_address = null;
	/**
	 * @var string user's preferred background
	 */
	public $background;
	/**
	 * @var string user's preferred border color
	 */
	public $border_color_name;
	/**
	 * @var string user's preferred border style (solid, inset, etc.)
	 */
	public $border_style;
	/**
	 * @var int user's preferred border width (in pixels)
	 */
	public $border_width;
	/**
	 * @var int user's preferred font_size (in pixels)
	 */
	public $font_size;
	/**
	 * @var date timestamp params added
	 */
	public $timestamp = null;

	/**
	 * Constructor
	 */
	public function __construct( &$db )
	{
		parent::__construct( '#__joomoositestyle', 'id', $db );

		// print "Hello from TableJoomooSitestyle::__construct()<br />\n";
	}

	/**
	 * Bind values in array to our data members
	 * @return boolean True if able to bind values else False
	 */
	public function bind( $data )
	{
		// print "Hello from TableJoomooSitestyle::bind()<br />\n";

		if ( isset($data->user_id) && 0 < $data->user_id )
		{
			$data->ip_address = '';
		}

		return parent::bind( $data );
	}

	/**
	 * Validator: ensure required values get set
	 * @return boolean True if values are valid else False
	 */
	public function check( $save_by_ip=FALSE )
	{
		// print "Hello from TableJoomooSitestyle::check()<br />\n";

		if ( ( isset($this->id) && 0 < $this->id ) || $save_by_ip )
		{
			if ( isset($this->background) && 0 < strlen($this->background) )
			{
				if ( ! isset(JoomooSitestyleColors::$backgroundColor[$this->background]) )
				{
					$this->setError( JText::_('Invalid value specified for background color.') );
					return false;
				}
			}
			else
			{
				unset($this->background);
			}
			if ( isset($this->border_color_name) && 0 < strlen($this->border_color_name) )
			{
				if ( ! isset(JoomooSitestyleColors::$borderColor[$this->border_color_name]) )
				{
					$this->setError( JText::_('Invalid value specified for border_color_name.') );
					return false;
				}
			}
			else
			{
				unset($this->border_color_name);
			}
			if ( isset($this->border_style) && 0 < strlen($this->border_style))
			{
				switch ( $this->border_style )
				{
					case "groove":
					case "ridge":
					case "double":
					case "inset":
					case "outset":
					case "solid":
					case "dashed":
					case "dotted":
					case "none":
						break;
					default:
						$this->setError( JText::_('Invalid value (' . $this->border_style . ') specified for border_style.') );
						return false;
				}
			}
			else
			{
				unset($this->border_style);
			}
			if ( isset($this->border_width) && 0 < strlen($this->border_width) && is_numeric($this->border_width) )
			{
				$this->border_width = (int) $this->border_width;
				if ( $this->border_width < JoomooSitestyleLimits::$minimum_border_width )
				{
					$this->setError( JText::_('Value specified for border_width (' . $this->border_width . ') is too low.') );
					return false;
				}
				if ( JoomooSitestyleLimits::$maximum_border_width < $this->border_width )
				{
					$this->setError( JText::_('Value specified for border_width (' . $this->border_width . ') is too high.') );
					return false;
				}
			}
			else
			{
				unset($this->border_width);
			}
			if ( isset($this->font_size) && 0 < strlen($this->font_size) && is_numeric($this->font_size) )
			{
				$this->font_size = (int) $this->font_size;
				if ( $this->font_size < JoomooSitestyleLimits::$minimum_font_size )
				{
					$this->setError( JText::_('Value specified for font_size (' . $this->font_size . ') is too low.') );
					return false;
				}
			    if ( JoomooSitestyleLimits::$maximum_font_size <  $this->font_size )
				{
					$this->setError( JText::_('Value specified for font_size (' . $this->font_size . ') is too high.') );
					return false;
				}
			}
			else
			{
				unset($this->font_size);
			}
		}
		else
		{
			$this->setError( JText::_('Neither user_id nor save_by_ip is set.  Why are we here?') );
			return false;
		}

		return true;
	}
//	/**
//	 * we are having issues with store, let's override it temporarily to see WTF is going on
//	 * @return boolean True if values are valid else False
//	 */
//	public function store()
//	{
//		print "Hello from TableJoomooSitestyle::store()<br />\n";
//		return parent::store();
//	}
}
