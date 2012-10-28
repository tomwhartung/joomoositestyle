<?php
/**
 * @version     $Id: JoomooSitestyleColors.php,v 1.14 2009/05/18 17:58:00 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/**
 * joomoositestyle color definitions - static class (DO NOT INSTANTIATE!)
 * set static hex values for colors used for backgrounds and borders
 */
class JoomooSitestyleColors
{
	/**
	 * Heading Colors: these are the colors used in headings
	 * We also need these to set the colors in the Accordion objects used in
	 *    components/com_joomoositestyle/assets/addEvents.js
	 * @access private
	 */
	private static $_headingColor = array (
		'blue'   => '#3377ff',
		'green'  => '#0dbe0d',
		'red'    => '#ff0d0d',
		'yellow' => '#bdbe0d',
	);

	/**
	 * Link Colors: these are the colors used in links
	 * We also need these to set the colors in the Accordion objects used in
	 *    components/com_joomoositestyle/assets/addEvents.js
	 * @access private
	 */
	private static $_linkColor = array (
		'blue'   => '#3377ff',
		'green'  => '#0dbe0d',
		'red'    => '#ff0d0d',
		'yellow' => '#bdbe0d',
	);
	/**
	 * Hover Colors: these are the colors used when user hovers mouse over links
	 * @access private
	 */
	private static $_hoverColor = array (
		'blue'   => '#0000ff',
		'green'  => '#008e00',
		'red'    => '#aa0000',
		'yellow' => '#8a8b00',
	);

	/**
	 * Input Background Colors: these are the colors used for the background of input tags
	 * @access private
	 */
	private static $_inputBackgroundColor = array (
		'blue'   => '#5b5be6',
		'green'  => '#5be65b',
		'red'    => '#e65b5b',
		'yellow' => '#e6e65b',
	);
	/**
	 * Input Border Colors: these are the colors used for the borders of input tags
	 * @access private
	 */
	private static $_inputBorderColor = array (
		'blue'   => '#5b5be6',
		'green'  => '#5be65b',
		'red'    => '#e65b5b',
		'yellow' => '#e6e65b',
	);

	/**
	 * Bullet Colors: these are the colors used in bullets
	 * Values used in corresponding images in *all* subdirectories of ../images/bullets/
	 * We also use these to set the border colors in JoomooSitestyle.js
	 * @access private
	 */
	private static $_bulletColor = array (
		'blue'   => '#0d0dbd',   // matches bullets (images)
		'green'  => '#0dbe0d',   // matches bullets (images)
		'red'    => '#bd0d0d',   // matches bullets (images)
		'yellow' => '#bdbe0d',   // matches bullets (images)
	);

	/*
	 * Background Colors:
	 * Let's keep this list alphabetized, so it's easy to see which colors are already defined
	 * If you add, delete, or change these, you may also need to change:
	 *    templates/joomoositestyle/templateDetails.xml
	 *    templates/joomoositestyle/javascript/JoomooSitestyle.js
	 *    components/com_joomoositestyle/assets/addEvents.js
	 */
	public static $backgroundColor = array (
		'image'           => '#000000',   // needed by TableJoomooSitestyleParams::check()
		'army_green'      => '#4B5320',   // from wikipedia
		'bistre'          => '#3D2B1F',   // from wikipedia
		'black'           => '#000000',
		'dark_blue'       => '#000022',   // made up by moi
		'dark_green'      => '#013220',   // from wikipedia
		'dark_grey'       => '#111111',   // made up by moi
		'dark_red'        => '#220000',   // made up by moi
		'dark_scarlet'    => '#560319',   // from wikipedia
		'falu_red'        => '#801818',   // from wikipedia
		'navy_blue'       => '#000080',   // from wikipedia
		'persian_indigo'  => '#32127A',   // from wikipedia
		'sapphire'        => '#082567',   // from wikipedia
		'seal_brown'      => '#321414',   // from wikipedia
		'tyrian_purple'   => '#66023C',   // from wikipedia
		'very_dark_green' => '#002200',   // made up by moi
		'very_dark_grey'  => '#111111',   // made up by moi
	);
	/*
	 * Border Colors:
	 * Let's keep this list alphabetized, so it's easy to see which colors are already defined
	 * If you add, delete, or change these, you may also need to change:
	 *    templates/joomoositestyle/templateDetails.xml
	 *    templates/joomoositestyle/javascript/JoomooSitestyle.js
	 *    components/com_joomoositestyle/assets/addEvents.js
	 */
	public static $borderColor = array (
		'blue'   => '#0d0dbd',   // matches bullets
		'green'  => '#0dbe0d',   // matches bullets
		'red'    => '#bd0d0d',   // matches bullets
		'yellow' => '#bdbe0d',   // matches bullets
		'black'           => '#000000',
		'cobalt'          => '#0047AB',   // from wikipedia
		'dark_slate_grey' => '#2F4F4F',   // from wikipedia
		'grey'            => '#808080',   // from wikipedia
		'maroon'          => '#800000',   // from wikipedia
		'orange_red'      => '#FF4500',   // from wikipedia
		'pine_green'      => '#01796F',   // from wikipedia
		'shocking_pink'   => '#FC0FC0',   // from wikipedia
		'silver'          => '#C0C0C0',   // from wikipedia
		'slate_grey'      => '#708090',   // from wikipedia
		'violet'          => '#8048A8',   // from wikipedia
		'white'           => '#ffffff',
	);

	/**
	 * Constructor - let programmer know we should not be instantiated!
	 */
	public function __construct( )
	{
		print "Hello from JoomooSitestyleColors::__construct() in classes/JoomooSitestyleColors.php<br />\n";
		print "Umm, this class defines only static members, there's no reason to instantiate it!<br />\n";
		print "Well whatever, goodbye from JoomooSitestyleColors::__construct() in classes/JoomooSitestyleColors.php!!<br />\n";
	}

	/**
	 * write a style tag setting these values in CSS
	 * @access public
	 * @return void
	 */
	public static function writeStyleSheet( $heading_color, $link_color, $input_color )
	{
		print ' <!-- Begin output by JoomooSitestyleColors::exportToCss -->' . "\n";
		print '  <style type="text/css">' . "\n";

		JoomooSitestyleColors::_writeHeadingStyles( $heading_color );
		JoomooSitestyleColors::_writeLinkStyles( $link_color );
		JoomooSitestyleColors::_writeInputStyles( $input_color );

		print '  </style>' . "\n";
		print ' <!-- End output from JoomooSitestyleColors::exportToCss -->' . "\n";
	}
	/**
	 * write heading styles
	 * @access private
	 * @return void
	 */
	private static function _writeHeadingStyles( $heading_color )
	{
		$headingColor = JoomooSitestyleColors::$_headingColor[$heading_color];

		print '   h1, h2, h3, h4, h5, h6' . "\n";
		print '   { color: ' . $headingColor . '; } ' . "\n";

		/*
		 * This class and contextual relationship were (along with h3)
		 * in the original rhuk_milkyway/css/blue.css style sheet
		 */
		print '   .componentheading, table.moduletable th' . "\n";
		print '   { color: ' . $headingColor . '; }' . "\n";

		/*
		 * These classes and contextual relationships were copied from styles in
		 * ../template.css that had colors assigned.  Those colors were commented out.
		 * Not sure how relevant these are (i.e., not sure they are used in my template).
		 */
		print '   .componentheading, .contentheading, table.contentpaneopen h4, div.module_menu h3' . "\n";
		print '   { color: ' . $headingColor . '; }' . "\n";

	}
	/**
	 * write link (anchor tag) styles
	 * @access private
	 * @return void
	 */
	private static function _writeLinkStyles( $link_color )
	{
		$linkColor = JoomooSitestyleColors::$_linkColor[$link_color];
		$hoverColor = JoomooSitestyleColors::$_hoverColor[$link_color];

		print '   a:link, a:visited,' . "\n";
		print '   span.joomoositestyle_control                    /* want joomoositestyle_controls to look like links */' . "\n";
		print '   { color: ' . $linkColor . ';}' . "\n";

		print '   a:hover, span.joomoositestyle_control:hover     /* want joomoositestyle_controls to look like links */' . "\n";
		print '   { color: ' . $hoverColor . ';}' . "\n";

		print '   div.joomoositestyle_slider                    /* want joomoositestyle_slider to look like links */' . "\n";
		print '   { background: ' . $linkColor . ';}' . "\n";
		print '   div.joomoositestyle_slider div.font_size_knob,' . "\n";
		print '   div.joomoositestyle_slider div.border_width_knob' . "\n";
		print '   { background: #ffffff;}' . "\n";
	}
	/**
	 * write styles for input controls (eg. text boxes)
	 * @access private
	 * @return void
	 */
	private static function _writeInputStyles( $input_color )
	{
		$backgroundColor = JoomooSitestyleColors::$_inputBackgroundColor[$input_color];
		$borderColor = JoomooSitestyleColors::$_inputBorderColor[$input_color];

		print '   input, button, option, select, textarea' . "\n";
		print '   { background-color: ' . $backgroundColor . '; border-color: ' . $borderColor . '; }' . "\n";
	}
	/**
	 * write unordered list (ul tag) styles
	 * @access public
	 * @return void
	 */
	public static function writeBulletStyles( $baseurl, $template, $bullet_color )
	{
		$imagePath = $baseurl .DS. 'templates' .DS. $template .DS. 'images' .DS. 'bullets' .DS. $bullet_color;

		print ' <!-- Begin output by JoomooSitestyleColors::writeBulletStyles -->' . "\n";
		print '  <style type="text/css">' . "\n";

		print '   ul, ul.menu, ul.arrow_4, li.arrow_4' . "\n";
		print "   { list-style-image: url('" . $imagePath . "/arrow-11x11-4.gif'); }\n";

		print '   ul ul, ul.menu ul, ul.arrow_3, li.arrow_3' . "\n";
		print "   { list-style-image: url('" . $imagePath . "/arrow-11x11-3.gif'); }\n";

		print '   ul ul ul, ul.menu ul ul, ul.arrow_2, li.arrow_2' . "\n";
		print "   { list-style-image: url('" . $imagePath . "/arrow-11x11-3.gif'); }\n";

		print '   ul ul ul ul, ul.menu ul ul ul, ul.arrow_1, li.arrow_1' . "\n";
		print "   { list-style-image: url('" . $imagePath . "/arrow-11x11-1.gif'); }\n";

		print '  </style>' . "\n";
		print ' <!-- End output from JoomooSitestyleColors::writeBulletStyles -->' . "\n";
	}

	/**
	 * write a script tag setting these values in Javascript
	 * NOTE: I think this script is obsolete.  The javascript was not being read in time for the array to
	 * get the values, so I had to hard-code the values and I don't think these are being used.
	 * Note call to this method is commented out in the template's index.php file.
	 * @access public
	 * @return void
	 */
	public static function exportToJavascript( )
	{
		print ' <!-- Begin output by JoomooSitestyleColors::exportToJavascript -->' . "\n";
		print '  <script type="text/javascript">' . "\n";
		print '   //<![CDATA[ ' . "\n";
		print "    var JoomooSitestyle;\n";
		print '    if ( ! JoomooSitestyle ) { JoomooSitestyle = {}; }' . "\n";

		print "    JoomooSitestyle.bullet_blue   = '" . JoomooSitestyleColors::$_bulletColor['blue']     . "';\n";
		print "    JoomooSitestyle.bullet_green  = '" . JoomooSitestyleColors::$_bulletColor['green']    . "';\n";
		print "    JoomooSitestyle.bullet_red    = '" . JoomooSitestyleColors::$_bulletColor['red']      . "';\n";
		print "    JoomooSitestyle.bullet_yellow = '" . JoomooSitestyleColors::$_bulletColor['yellow']   . "';\n";
		print "\n";
		print "    JoomooSitestyle.heading_blue   = '" . JoomooSitestyleColors::$_headingColor['blue']     . "';\n";
		print "    JoomooSitestyle.heading_green  = '" . JoomooSitestyleColors::$_headingColor['green']    . "';\n";
		print "    JoomooSitestyle.heading_red    = '" . JoomooSitestyleColors::$_headingColor['red']      . "';\n";
		print "    JoomooSitestyle.heading_yellow = '" . JoomooSitestyleColors::$_headingColor['yellow']   . "';\n";
		print "\n";
		print "    JoomooSitestyle.link_blue   = '" . JoomooSitestyleColors::$_linkColor['blue']     . "';\n";
		print "    JoomooSitestyle.link_green  = '" . JoomooSitestyleColors::$_linkColor['green']    . "';\n";
		print "    JoomooSitestyle.link_red    = '" . JoomooSitestyleColors::$_linkColor['red']      . "';\n";
		print "    JoomooSitestyle.link_yellow = '" . JoomooSitestyleColors::$_linkColor['yellow']   . "';\n";
		print "\n";
		print "    JoomooSitestyle.army_green      = '" . JoomooSitestyleColors::$backgroundColor['army_green']      . "';\n";
		print "    JoomooSitestyle.bistre          = '" . JoomooSitestyleColors::$backgroundColor['bistre']          . "';\n";
		print "    JoomooSitestyle.black           = '" . JoomooSitestyleColors::$backgroundColor['black']           . "';\n";
		print "    JoomooSitestyle.dark_blue       = '" . JoomooSitestyleColors::$backgroundColor['dark_blue']       . "';\n";
		print "    JoomooSitestyle.dark_green      = '" . JoomooSitestyleColors::$backgroundColor['dark_green']      . "';\n";
		print "    JoomooSitestyle.dark_grey       = '" . JoomooSitestyleColors::$backgroundColor['dark_grey']       . "';\n";
		print "    JoomooSitestyle.dark_red        = '" . JoomooSitestyleColors::$backgroundColor['dark_red']        . "';\n";
		print "    JoomooSitestyle.dark_scarlet    = '" . JoomooSitestyleColors::$backgroundColor['dark_scarlet']    . "';\n";
		print "    JoomooSitestyle.falu_red        = '" . JoomooSitestyleColors::$backgroundColor['falu_red']        . "';\n";
		print "    JoomooSitestyle.navy_blue       = '" . JoomooSitestyleColors::$backgroundColor['navy_blue']       . "';\n";
		print "    JoomooSitestyle.persian_indigo  = '" . JoomooSitestyleColors::$backgroundColor['persian_indigo']  . "';\n";
		print "    JoomooSitestyle.sapphire        = '" . JoomooSitestyleColors::$backgroundColor['sapphire']        . "';\n";
		print "    JoomooSitestyle.seal_brown      = '" . JoomooSitestyleColors::$backgroundColor['seal_brown']      . "';\n";
		print "    JoomooSitestyle.tyrian_purple   = '" . JoomooSitestyleColors::$backgroundColor['tyrian_purple']   . "';\n";
		print "    JoomooSitestyle.very_dark_green = '" . JoomooSitestyleColors::$backgroundColor['very_dark_green'] . "';\n";
		print "    JoomooSitestyle.very_dark_grey  = '" . JoomooSitestyleColors::$backgroundColor['very_dark_grey']  . "';\n";
		print "\n";
		print "    JoomooSitestyle.cobalt          = '" . JoomooSitestyleColors::$borderColor['cobalt']          . "';\n";
		print "    JoomooSitestyle.dark_slate_grey = '" . JoomooSitestyleColors::$borderColor['dark_slate_grey'] . "';\n";
		print "    JoomooSitestyle.grey            = '" . JoomooSitestyleColors::$borderColor['grey']            . "';\n";
		print "    JoomooSitestyle.maroon          = '" . JoomooSitestyleColors::$borderColor['maroon']          . "';\n";
		print "    JoomooSitestyle.orange_red      = '" . JoomooSitestyleColors::$borderColor['orange_red']      . "';\n";
		print "    JoomooSitestyle.pine_green      = '" . JoomooSitestyleColors::$borderColor['pine_green']      . "';\n";
		print "    JoomooSitestyle.shocking_pink   = '" . JoomooSitestyleColors::$borderColor['shocking_pink']   . "';\n";
		print "    JoomooSitestyle.silver          = '" . JoomooSitestyleColors::$borderColor['silver']          . "';\n";
		print "    JoomooSitestyle.slate_grey      = '" . JoomooSitestyleColors::$borderColor['slate_grey']      . "';\n";
		print "    JoomooSitestyle.violet          = '" . JoomooSitestyleColors::$borderColor['violet']          . "';\n";
		print "    JoomooSitestyle.white           = '" . JoomooSitestyleColors::$borderColor['white']           . "';\n";
		print '   //]]>' . "\n";
		print '  </script>' . "\n";
		print ' <!-- End output from JoomooSitestyleColors::exportToJavascript -->' . "\n";
	}
}
