<?php
/**
 * @version     $Id: ViewFunctions.php,v 1.1 2009/05/10 16:41:29 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

require_once 'JoomooSitestyleLimits.php';

/**
 * View functions shared by JoomooSitestyle component and module
 */
class ViewFunctions
{
	/**
	 * Constructor
	 */
	public function __construct( )
	{
		print "Hello from ViewFunctions::__construct() in classes/ViewFunctions.php<br />\n";
	}

	/**
	 * print a select tag for setting border width value
	 */
	public function printSelectBorderWidth( $id, $name="" )
	{
		print ' <!-- Begin output by ViewFunctions::printSelectBorderWidth -->' . "\n";
		print '  <select id="' . $id . ' name="' . $name . '">' . "\n";

		for ( $width  = JoomooSitestyleLimits::$minimum_border_width;
		      $width <= JoomooSitestyleLimits::$maximum_border_width;
		      $width += JoomooSitestyleLimits::$border_width_increment )
		{
			print '   <option value="' . $width . '">' . $width . '%</option>' . "\n";
		}

		print '  </select>' . "\n";
		print ' <!-- End output from ViewFunctions::printSelectBorderWidth -->' . "\n";
	}
}
