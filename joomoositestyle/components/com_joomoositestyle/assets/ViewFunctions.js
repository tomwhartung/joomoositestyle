/**
 * @version     $Id: ViewFunctions.js,v 1.21 2009/05/14 15:45:46 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

/*
 * ViewFunctions.js: functions to support views in this component
 */
var ViewFunctions;
if ( ! ViewFunctions ) { ViewFunctions = {}; }

ViewFunctions._tdBorderWidth;
ViewFunctions._minimumTdBorderWidth = 2;

/**
 * Get border width style param for td (table data) elements
 * We want to base this value on the current value for this user
 * (Utility function used by multiple functions in this file)
 */
ViewFunctions._getTdBorderWidth = function ()
{
	if ( ViewFunctions._tdBorderWidth === undefined )
	{
		ViewFunctions._tdBorderWidth = parseInt(JoomooSitestyle.border_width / 2);
		if ( ViewFunctions._tdBorderWidth < ViewFunctions._minimumTdBorderWidth )
		{
			ViewFunctions._tdBorderWidth = ViewFunctions._minimumTdBorderWidth;
		}
	}

	return ViewFunctions._tdBorderWidth;
}

/**
 * print table with options for setting background
 */
ViewFunctions.printBackgroundTable = function ( )
{
	var columns = 4;
	var columnNum = 1;
	var colorValue;
	var colorNameNoUnderlines;

	document.write( "<table class='background' cellpadding='0' cellspacing='0'>\n" );
	document.write( " <tr>\n" );

	/*
	 * This is where we write the HTML
	 */
	for ( var colorName in JoomooSitestyle.backgroundArray )
	{
		colorValue = JoomooSitestyle.backgroundArray[colorName];
		colorNameNoUnderlines = JoomooSitestyle.replaceUnderlines ( colorName );
		document.write( "  <td class='background'" );
		if ( colorName == 'image' )
		{
			document.write( ">\n" );
		}
		else
		{
			document.write( " style='background-color:" + colorValue + ";'" + ">\n" );
		}
		document.write( "   <span class='joomoositestyle_control' id='" + colorName + "_background'>" );
		if ( colorName == JoomooSitestyle.default_background )
		{
			document.write( colorNameNoUnderlines + " (default)</span>\n" );
		}
		else
		{
			document.write( colorNameNoUnderlines + "</span>\n" );
		}
		document.write( "  </td>\n" );
		if ( columnNum++ == columns )
		{
			document.write( " </tr>\n" );
			document.write( " <tr>\n" );
			columnNum = 1;
		}
	}

	document.write( " </tr>\n" );
	document.write( "</table>\n" );
	/*
	 * Set up the events - tried to do this in a loop but it didn't work(?!?)
	 * If you add a color here you must also add it to:
	 *    templates/joomoositestyle/templateDetails.xml (enables setting it up in backend)
	 *    templates/joomoositestyle/classes/JoomooSitestyleColors.js
	 */
	$('army_green_background').addEvent     ('click', function(e) { JoomooSitestyle.setBackground ('army_green'     ); JoomooSitestyle.store('background'); });
	$('bistre_background').addEvent         ('click', function(e) { JoomooSitestyle.setBackground ('bistre'         ); JoomooSitestyle.store('background'); });
	$('black_background').addEvent          ('click', function(e) { JoomooSitestyle.setBackground ('black'          ); JoomooSitestyle.store('background'); });
	$('dark_blue_background').addEvent      ('click', function(e) { JoomooSitestyle.setBackground ('dark_blue'      ); JoomooSitestyle.store('background'); });
	$('dark_green_background').addEvent     ('click', function(e) { JoomooSitestyle.setBackground ('dark_green'     ); JoomooSitestyle.store('background'); });
	$('dark_scarlet_background').addEvent   ('click', function(e) { JoomooSitestyle.setBackground ('dark_scarlet'   ); JoomooSitestyle.store('background'); });
	$('dark_red_background').addEvent       ('click', function(e) { JoomooSitestyle.setBackground ('dark_red'       ); JoomooSitestyle.store('background'); });
	$('falu_red_background').addEvent       ('click', function(e) { JoomooSitestyle.setBackground ('falu_red'       ); JoomooSitestyle.store('background'); });
	$('image_background').addEvent          ('click', function(e) { JoomooSitestyle.setBackground ('image'          ); JoomooSitestyle.store('background'); });
	$('navy_blue_background').addEvent      ('click', function(e) { JoomooSitestyle.setBackground ('navy_blue'      ); JoomooSitestyle.store('background'); });
	$('persian_indigo_background').addEvent ('click', function(e) { JoomooSitestyle.setBackground ('persian_indigo' ); JoomooSitestyle.store('background'); });
	$('sapphire_background').addEvent       ('click', function(e) { JoomooSitestyle.setBackground ('sapphire'       ); JoomooSitestyle.store('background'); });
	$('seal_brown_background').addEvent     ('click', function(e) { JoomooSitestyle.setBackground ('seal_brown'     ); JoomooSitestyle.store('background'); });
	$('tyrian_purple_background').addEvent  ('click', function(e) { JoomooSitestyle.setBackground ('tyrian_purple'  ); JoomooSitestyle.store('background'); });
	$('very_dark_green_background').addEvent('click', function(e) { JoomooSitestyle.setBackground ('very_dark_green'); JoomooSitestyle.store('background'); });
	$('very_dark_grey_background').addEvent ('click', function(e) { JoomooSitestyle.setBackground ('very_dark_grey' ); JoomooSitestyle.store('background'); });
	$('reset_background').addEvent('click', function(e) { JoomooSitestyle.setBackground( JoomooSitestyle.default_background ); });
}

/**
 * print table with options for setting border color
 */
ViewFunctions.printBorderColorTable = function ( )
{
	var columns = 4;
	var columnNum = 1;
	var colorValue;
	var tdBorderWidth = ViewFunctions._getTdBorderWidth();
	var colorNameNoUnderlines;

	var borderStyleParam;
	var borderWidthParam;
	var styleParams;

	borderStyleParam = "border-style: " + JoomooSitestyle.border_style + "; ";
	borderWidthParam = "border-width: " + tdBorderWidth + "px; ";

	document.write( "<table class='border_color_name'>\n" );
	document.write( " <tr>\n" );

	/*
	 * This is where we write the HTML
	 */
	for ( var colorName in JoomooSitestyle.borderColorArray )
	{
		colorValue = JoomooSitestyle.borderColorArray[colorName];
		colorNameNoUnderlines = JoomooSitestyle.replaceUnderlines ( colorName );
		styleParams = "border-color: " + colorValue + "; " + borderStyleParam + borderWidthParam;

		document.write( "  <td class='border_color_name' style='" + styleParams + "'>\n" );
		document.write( "   <span class='joomoositestyle_control' id='" + colorName + "_border_color_name'>" );
		document.write( colorNameNoUnderlines + "</span>\n" );
		document.write( "  </td>\n" );
		if ( columnNum++ == columns )
		{
			document.write( " </tr>\n" );
			document.write( " <tr>\n" );
			columnNum = 1;
		}
	}
	document.write( " </tr>\n" );
	document.write( "</table>\n" );

	/*
	 * Set up the events - tried to do this in a loop but it didn't work(?!?)
	 * If you add a color here you must also add it to:
	 *    templates/joomoositestyle/templateDetails.xml (enables setting it up in backend)
	 *    templates/joomoositestyle/classes/JoomooSitestyleColors.js
	 */
	$('black_border_color_name').addEvent           ('click', function(e) { JoomooSitestyle.setBorderColorName ('black'          ); JoomooSitestyle.store('border_color_name'); });
	$('blue_border_color_name').addEvent            ('click', function(e) { JoomooSitestyle.setBorderColorName ('blue'           ); JoomooSitestyle.store('border_color_name'); });
	$('cobalt_border_color_name').addEvent          ('click', function(e) { JoomooSitestyle.setBorderColorName ('cobalt'         ); JoomooSitestyle.store('border_color_name'); });
	$('dark_slate_grey_border_color_name').addEvent ('click', function(e) { JoomooSitestyle.setBorderColorName ('dark_slate_grey'); JoomooSitestyle.store('border_color_name'); });
	$('green_border_color_name').addEvent           ('click', function(e) { JoomooSitestyle.setBorderColorName ('green'          ); JoomooSitestyle.store('border_color_name'); });
	$('grey_border_color_name').addEvent            ('click', function(e) { JoomooSitestyle.setBorderColorName ('grey'           ); JoomooSitestyle.store('border_color_name'); });
	$('maroon_border_color_name').addEvent          ('click', function(e) { JoomooSitestyle.setBorderColorName ('maroon'         ); JoomooSitestyle.store('border_color_name'); });
	$('orange_red_border_color_name').addEvent      ('click', function(e) { JoomooSitestyle.setBorderColorName ('orange_red'     ); JoomooSitestyle.store('border_color_name'); });
	$('pine_green_border_color_name').addEvent      ('click', function(e) { JoomooSitestyle.setBorderColorName ('pine_green'     ); JoomooSitestyle.store('border_color_name'); });
	$('red_border_color_name').addEvent             ('click', function(e) { JoomooSitestyle.setBorderColorName ('red'            ); JoomooSitestyle.store('border_color_name'); });
	$('silver_border_color_name').addEvent          ('click', function(e) { JoomooSitestyle.setBorderColorName ('silver'         ); JoomooSitestyle.store('border_color_name'); });
	$('slate_grey_border_color_name').addEvent      ('click', function(e) { JoomooSitestyle.setBorderColorName ('slate_grey'     ); JoomooSitestyle.store('border_color_name'); });
	$('shocking_pink_border_color_name').addEvent   ('click', function(e) { JoomooSitestyle.setBorderColorName ('shocking_pink'  ); JoomooSitestyle.store('border_color_name'); });
	$('violet_border_color_name').addEvent          ('click', function(e) { JoomooSitestyle.setBorderColorName ('violet'         ); JoomooSitestyle.store('border_color_name'); });
	$('white_border_color_name').addEvent           ('click', function(e) { JoomooSitestyle.setBorderColorName ('white'          ); JoomooSitestyle.store('border_color_name'); });
	$('yellow_border_color_name').addEvent          ('click', function(e) { JoomooSitestyle.setBorderColorName ('yellow'         ); JoomooSitestyle.store('border_color_name'); });
}

/**
 * print table with options for setting border style
 */
ViewFunctions.printBorderStyleTable = function ( )
{
	var style;
	var columns = 3;
	var columnNum = 1;
	var tdBorderWidth = ViewFunctions._getTdBorderWidth();

	var borderColorParam;
	var borderWidthParam;
	var styleParams;
	var idForEvent;

	borderColorParam = "border-color: " + JoomooSitestyle.borderColorArray[JoomooSitestyle.border_color_name] + "; ";
	borderWidthParam = "border-width: " + tdBorderWidth + "px; ";

	document.write( "<table class='border_style'>\n" );
	document.write( " <tr>\n" );

	/*
	 * This is where we write the HTML
	 */
	for ( var index = 0; index < JoomooSitestyle.borderStyleArray.length; index++ )
	{
		style = JoomooSitestyle.borderStyleArray[index];
		idForEvent = style + '_border_style';
		styleParams = "border-style: " + style + "; " + borderColorParam + borderWidthParam;

		document.write( "  <td class='border_style' style='" + styleParams + "'>\n" );
		document.write( "   <span class='joomoositestyle_control' id='" + idForEvent + "'>" + style + "</span>\n" );
		document.write( "  </td>\n" );
		if ( columnNum++ == columns )
		{
			document.write( " </tr>\n" );
			document.write( " <tr>\n" );
			columnNum = 1;
		}
	}
	document.write( " </tr>\n" );
	document.write( "</table>\n" );

	/*
	 * Set up the events - tried to do this in a loop but it didn't work(?!?)
	 */
	$('dashed_border_style').addEvent('click', function(e) { JoomooSitestyle.setBorderStyle('dashed'); JoomooSitestyle.store('border_style'); });
	$('dotted_border_style').addEvent('click', function(e) { JoomooSitestyle.setBorderStyle('dotted'); JoomooSitestyle.store('border_style'); });
	$('double_border_style').addEvent('click', function(e) { JoomooSitestyle.setBorderStyle('double'); JoomooSitestyle.store('border_style'); });
	$('groove_border_style').addEvent('click', function(e) { JoomooSitestyle.setBorderStyle('groove'); JoomooSitestyle.store('border_style'); });
	$('inset_border_style').addEvent('click',  function(e) { JoomooSitestyle.setBorderStyle('inset');  JoomooSitestyle.store('border_style'); });
	$('none_border_style').addEvent('click',   function(e) { JoomooSitestyle.setBorderStyle('none');   JoomooSitestyle.store('border_style'); });
	$('outset_border_style').addEvent('click', function(e) { JoomooSitestyle.setBorderStyle('outset'); JoomooSitestyle.store('border_style'); });
	$('ridge_border_style').addEvent('click',  function(e) { JoomooSitestyle.setBorderStyle('ridge');  JoomooSitestyle.store('border_style'); });
	$('solid_border_style').addEvent('click',  function(e) { JoomooSitestyle.setBorderStyle('solid');  JoomooSitestyle.store('border_style'); });
}

/**
 * print table with options for setting border width directly
 * This is not to be confused with the table with options for changing the border width
 */
ViewFunctions.printBorderWidthTable = function ( )
{
	var columns = 10;
	var columnNum = 1;
	var idForEvent;

	document.write( "<table class='set_border_width'>\n" );
	document.write( " <tr>\n" );

	for ( var width = JoomooSitestyle.minimum_border_width; width <= JoomooSitestyle.maximum_border_width; (width += JoomooSitestyle.border_width_increment) )
	{
		idForEvent = 'border_width_' + width;

		/* write the HTML: */
		document.write( "  <td class='set_border_width'>\n" );
		document.write( "   <span class='joomoositestyle_control' id='" + idForEvent + "'>" + width + "</span>\n" );
		document.write( "  </td>\n" );
		if ( columnNum++ == columns )
		{
			document.write( " </tr>\n" );
			document.write( " <tr>\n" );
			columnNum = 1;
		}

	//	/* set up the event - why won't this work?!?!? */
	//	$(idForEvent).addEvent (
	//		'click',
	//	//	function(e) { JoomooSitestyle.setBorderWidth( $(idForEvent).value ); JoomooSitestyle.store('border_width'); }
	//		function(e) {
	//			var child = $(idForEvent).firstChild;
	//			alert( 'idForEvent = ' + idForEvent + '; child.nodeValue = ' + child.nodeValue );
	//		}
	//	);
	}
	document.write( " </tr>\n" );
	document.write( "</table>\n" );
	/*
	 * Set up the events - tried to do this in a loop (see above) but it didn't work(?!?)
	 */
	$('border_width_0').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  0 ); JoomooSitestyle.store('border_width'); });
	$('border_width_1').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  1 ); JoomooSitestyle.store('border_width'); });
	$('border_width_2').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  2 ); JoomooSitestyle.store('border_width'); });
	$('border_width_3').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  3 ); JoomooSitestyle.store('border_width'); });
	$('border_width_4').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  4 ); JoomooSitestyle.store('border_width'); });
	$('border_width_5').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  5 ); JoomooSitestyle.store('border_width'); });
	$('border_width_6').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  6 ); JoomooSitestyle.store('border_width'); });
	$('border_width_7').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  7 ); JoomooSitestyle.store('border_width'); });
	$('border_width_8').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  8 ); JoomooSitestyle.store('border_width'); });
	$('border_width_9').addEvent('click',  function(e) { JoomooSitestyle.setBorderWidth(  9 ); JoomooSitestyle.store('border_width'); });
	$('border_width_10').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 10 ); JoomooSitestyle.store('border_width'); });
	$('border_width_11').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 11 ); JoomooSitestyle.store('border_width'); });
	$('border_width_12').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 12 ); JoomooSitestyle.store('border_width'); });
	$('border_width_13').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 13 ); JoomooSitestyle.store('border_width'); });
	$('border_width_14').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 14 ); JoomooSitestyle.store('border_width'); });
	$('border_width_15').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 15 ); JoomooSitestyle.store('border_width'); });
	$('border_width_16').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 16 ); JoomooSitestyle.store('border_width'); });
	$('border_width_17').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 17 ); JoomooSitestyle.store('border_width'); });
	$('border_width_18').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 18 ); JoomooSitestyle.store('border_width'); });
	$('border_width_19').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 19 ); JoomooSitestyle.store('border_width'); });
	$('border_width_20').addEvent('click', function(e) { JoomooSitestyle.setBorderWidth( 20 ); JoomooSitestyle.store('border_width'); });

}
