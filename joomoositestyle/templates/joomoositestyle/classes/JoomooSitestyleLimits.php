<?php
/**
 * @version     $Id: JoomooSitestyleLimits.php,v 1.4 2009/05/15 21:18:10 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  JoomooSitestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/**
 * JoomooSitestyle Limits Definitions - static class (DO NOT INSTANTIATE!)
 * We need these in both the PHP code and the Javascript code
 */
class JoomooSitestyleLimits
{
	/*
	 * Limits for border_width (px) and font_size (%)
	 */
	public static $minimum_border_width  =  0;
	public static $maximum_border_width  = 20;
	public static $border_width_increment = 1;

	public static $minimum_font_size =  60;
	public static $maximum_font_size = 150;
	public static $font_size_increment = 5;

	/**
	 * Constructor - let programmer know we should not be instantiated!
	 */
	public function __construct( )
	{
		print "Hello from JoomooSitestyleLimits::__construct() in classes/JoomooSitestyleLimits.php<br />\n";
		print "Umm, this class defines only static members, there's no reason to instantiate it!<br />\n";
		print "Well whatever, goodbye from JoomooSitestyleLimits::__construct() in classes/JoomooSitestyleLimits.php!!<br />\n";
	}

	/**
	 * write a script tag setting these values in Javascript
	 */
	public static function exportToJavascript( )
	{
		print ' <!-- Begin output by JoomooSitestyleLimits::exportToJavascript -->' . "\n";
		print '  <script type="text/javascript">' . "\n";
		print '   //<![CDATA[ ' . "\n";
		print "    var JoomooSitestyle;\n";
		print '    if ( ! JoomooSitestyle ) { JoomooSitestyle = {}; }' . "\n";
		print '    JoomooSitestyle.minimum_border_width = ' . JoomooSitestyleLimits::$minimum_border_width . ";\n";
		print '    JoomooSitestyle.maximum_border_width = ' . JoomooSitestyleLimits::$maximum_border_width . ";\n";
		print '    JoomooSitestyle.border_width_increment = ' . JoomooSitestyleLimits::$border_width_increment . ";\n";
		print '    JoomooSitestyle.minimum_font_size = ' . JoomooSitestyleLimits::$minimum_font_size . ";\n";
		print '    JoomooSitestyle.maximum_font_size = ' . JoomooSitestyleLimits::$maximum_font_size . ";\n";
		print '    JoomooSitestyle.font_size_increment = ' . JoomooSitestyleLimits::$font_size_increment . ";\n";
		print '   //]]>' . "\n";
		print '  </script>' . "\n";
		print ' <!-- End output from JoomooSitestyleLimits::exportToJavascript -->' . "\n";
	}
}
