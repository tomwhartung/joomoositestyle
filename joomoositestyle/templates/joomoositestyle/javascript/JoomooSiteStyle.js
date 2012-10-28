/**
 * @version     $Id: JoomooSitestyle.js,v 1.30 2009/05/15 21:40:50 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */
/**
 * JoomooSitestyle.js: functions to support customizing appearance of site
 * Notes:
 *    Default values are set in backend (see templates/joomoositestyle/templateDetails.xml)
 *       and made accessible to javascript in templates/joomoositestyle/index.php
 *    This package relies on:
 *       com_joomoobase/javascript/CookieHandler.js
 *       com_joomoobase/javascript/JoomooRequest.js
 */
var JoomooSitestyle;
if ( ! JoomooSitestyle ) { JoomooSitestyle = {}; }

/*
 * Variables used when setting any and all template parameters
 */
JoomooSitestyle._joomooSitestyleCookieValue;

/*
 * Variables used to set and change font size
 * Change the default in the back end (Extensions -> Templates -> [template name])
 * Change the values in the list in the back end in templates/joomoositestyle/templateDetails.xml
 */
JoomooSitestyle.font_size = JoomooSitestyle.default_font_size;

/*
 * These JoomooSitestyle.bullet_* colors match the colors used in bullets, headings, and links
 * --------------------------------------------------------------------------------------
 * We need these to set the colors in the Accordion objectss used in
 *    components/com_joomoositestyle/assets/addEvents.js
 * If you change them, you should also change:
 *    corresponding file(s) in ../css/headings/
 *    corresponding file(s) in ../css/links/
 *    corresponding file(s) in *all* subdirectories of ../images/bullets/
 */

/*
 * Variables used to set and change background
 */
JoomooSitestyle.background = JoomooSitestyle.default_background;
/*
 * Note: image background works in safari only if it's also specified in the template's css file
 *     i.e., templates/joomoositestyle/css/template.css
 */
JoomooSitestyle.backgroundImage = '/templates/joomoositestyle/images/background.jpg';

/*
 * ---------------------------
 * Supported Background Colors
 * ---------------------------
 * Let's try to sequence these from dark to light (after initial unique i.e. "image")
 * If you add it here you must also add it to:
 *    templates/joomoositestyle/templateDetails.xml (enables setting it up in backend)
 *    templates/joomoositestyle/classes/JoomooSitestyleColors.php (enables using colors when javascript is off)
 *    components/com_joomoositestyle/assets/addEvents.js
 */
JoomooSitestyle.backgroundArray =
{
	'image'           : 'image',
	'black'           :  '#000000',
	'dark_blue'       :  '#000022',
	'dark_red'        :  '#220000',
	'very_dark_green' :  '#002200',
	'very_dark_grey'  :  '#111111',
	'navy_blue'       :  '#000080',
	'dark_green'      :  '#013220',
	'seal_brown'      :  '#321414',
	'tyrian_purple'   :  '#66023C',
	'persian_indigo'  :  '#32127A',
	'bistre'          :  '#3D2B1F',
	'dark_scarlet'    :  '#560319',
	'army_green'      :  '#4B5320',
	'sapphire'        :  '#082567',
	'falu_red'        :  '#801818'
};
/*
 * -----------------------
 * Supported Border Colors
 * -----------------------
 * Let's try to sequence these from light to dark (after initial bullet_* colors)
 * If you add it here you must also add it to:
 *    templates/joomoositestyle/templateDetails.xml (enables setting it up in backend)
 *    templates/joomoositestyle/classes/JoomooSitestyleColors.php (enables using colors when javascript is off)
 *    components/com_joomoositestyle/assets/addEvents.js
 */
JoomooSitestyle.borderColorArray =
{
	'blue'            : '#0d0dbd',
	'green'           : '#0dbe0d',
	'red'             : '#bd0d0d',
	'yellow'          : '#bdbe0d',
	'black'           : '#000000',
	'cobalt'          : '#0047AB',
	'pine_green'      : '#01796F',
	'dark_slate_grey' : '#2F4F4F',
	'slate_grey'      : '#708090',
	'maroon'          : '#800000',
	'grey'            : '#808080',
	'violet'          : '#8048A8',
	'silver'          : '#C0C0C0',
	'shocking_pink'   : '#FC0FC0',
	'orange_red'      : '#FF4500',
	'white'           : '#FFFFFF'
};

/*
 * Variables used to set and change color of borders
 */
JoomooSitestyle.border_color_name  = JoomooSitestyle.default_border_color_name;
JoomooSitestyle.border_color_value = JoomooSitestyle.borderColorArray[JoomooSitestyle.border_color_name];

/*
 * Variables used to set and change style of borders
 */
JoomooSitestyle.border_style = JoomooSitestyle.default_border_style;
JoomooSitestyle.borderStyleArray = new Array (
	'dashed', 'dotted', 'double',
	'groove', 'inset', 'outset',
	'ridge', 'solid', 'none'
);

/*
 * Variable used to set and change width of borders
 * Change the default in the back end (Extensions -> Templates -> [template name])
 */
JoomooSitestyle.border_width = JoomooSitestyle.default_border_width;

/**
 * replace underlines in a string (e.g., a color name) with spaces
 * @return string with spaces instead of underlines
 */
JoomooSitestyle.replaceUnderlines = function ( withUnderlines )
{
	var underlineRegex = /_/g;
	var noUnderlines = withUnderlines.replace( underlineRegex, " " );
	return noUnderlines;
};

/**
 * set font_size to desiredFontSize
 */
JoomooSitestyle.setFontSize = function ( desiredFontSize )
{
	var stObj;

	stObj = (document.getElementById) ? document.getElementById('content_area') : document.all('content_area');

	if ( isNaN(desiredFontSize) )
	{
		desiredFontSize = JoomooSitestyle.default_font_size;
	}
	else if ( desiredFontSize < JoomooSitestyle.minimum_font_size )
	{
		desiredFontSize = JoomooSitestyle.minimum_font_size;
	}
	else if ( JoomooSitestyle.maximum_font_size < desiredFontSize )
	{
		desiredFontSize = JoomooSitestyle.maximum_font_size;
	}

	JoomooSitestyle.font_size = parseInt(desiredFontSize);
	document.body.style.fontSize = JoomooSitestyle.font_size + '%';

	if ( $('font_size_for_header') != null )   // defined only on the com_joomoositestyle page
	{
		$('font_size_for_header').set('html', "(" + JoomooSitestyle.font_size + '%)<\/span>');
	}
	if ( $('font_size_log') != null )          // defined only on the com_joomoositestyle page
	{
		$('font_size_log').set('html', JoomooSitestyle.font_size + '%.<\/span>' );
	}

	/*
	 * we may have multiple instances of the module on a page
	 */
	var fontSizeIndex = Math.round(JoomooSitestyle.font_size - JoomooSitestyle.minimum_font_size) / JoomooSitestyle.font_size_increment;
	var selectTagId;
	for ( var instance = 0; instance < ViewFunctions.instanceFontSizeSelect; instance++ )
	{
		selectTagId = 'select_font_size_' + instance;
		if ( $(selectTagId) != null ) { $(selectTagId).selectedIndex = fontSizeIndex; }
	}

	var fontSizeForSlider = ( JoomooSitestyle.font_size - JoomooSitestyle.minimum_font_size ) /
			JoomooSitestyle.font_size_increment;
	for ( var instance = 0; instance < ViewFunctions.fontSizeSliders.length; instance++ )
	{
		if ( ViewFunctions.fontSizeSliders[instance] != null )
		{
			ViewFunctions.fontSizeSliders[instance].set(fontSizeForSlider);
		}
		// /* Couldn't get this to work */
		// var knobId, sliderId, var percent = JoomooSitestyle.font_size + '%';
		// knobId = 'font_size_knob_' + instance; sliderId = 'font_size_slider_' + instance;
		// if ( $(knobId) != null ) { $(knobId).setAttribute('height', percent); $(knobId).setAttribute('width', percent); }
		// if ( $(sliderId) != null ) { $(sliderId).setAttribute('height', percent); $(sliderId).setAttribute('width', percent); }
	}
};

/**
 * change font size by delta percent
 */
JoomooSitestyle.changeFontSize = function (delta)
{
	var desiredFontSize;

	desiredFontSize = parseInt(JoomooSitestyle.font_size) + parseInt(delta);
	JoomooSitestyle.setFontSize(desiredFontSize);
};

/**
 * get index of selected border color option
 * used to set selectedIndex attr of select tag in module
 * @return 0-based index of border color name
 */
JoomooSitestyle._getBackgroundIndex = function ( givenBackground )
{
	var backgroundIndex = 0;

	for ( var background in JoomooSitestyle.backgroundArray )
	{
		if ( background == givenBackground )
		{
			break;
		}
		backgroundIndex++;
	}

	return backgroundIndex;
}
/**
 * set page's background image or color
 * desiredBackground: name of color desired for background, e.g., 'army_green'
 */
JoomooSitestyle.setBackground = function ( desiredBackground )
{
	var backgroundLogText;
	var backgroundForHeaderText;

	if ( desiredBackground in JoomooSitestyle.backgroundArray )
	{
		JoomooSitestyle.background = desiredBackground;
	}
	else
	{
		JoomooSitestyle.background = JoomooSitestyle.default_background;
	}

	if ( JoomooSitestyle.background == 'image' )
	{
		var backgroundImageParam = 'url("' +  JoomooSitestyle.backgroundImage + '")';
		$('page_bg').setStyle('background-image', backgroundImageParam );
		// document.write( "JoomooSitestyle.setBackground: setting background-image style to \"" + backgroundImageParam + "\"<br />\n" );
		// backgroundLogText = 'image: "' + backgroundImageParam + '".<\/span>';
		backgroundLogText = 'image.<\/span>';
		backgroundForHeaderText = ' (image)<\/span>';
	}
	else
	{
		var backgroundNoUnderlines = JoomooSitestyle.replaceUnderlines ( JoomooSitestyle.background );
		$('page_bg').setStyle( 'background', JoomooSitestyle.backgroundArray[JoomooSitestyle.background] );
		backgroundLogText = backgroundNoUnderlines + '.<\/span>';
		backgroundForHeaderText = ' (' + backgroundNoUnderlines + ')<\/span>';
	}

	if ( $('background_for_header') != null )   // defined only on the com_joomoositestyle page
	{
		$('background_for_header').set('html', backgroundForHeaderText );
	}
	if ( $('background_log') != null )         // defined only on the com_joomoositestyle page
	{
		$('background_log').set('html', backgroundLogText );
	}

	/*
	 * we may have multiple instances of the module on a page
	 */
	var backgroundIndex = JoomooSitestyle._getBackgroundIndex( JoomooSitestyle.background );
	var selectTagId;
	for ( instance = 0; instance < ViewFunctions.instanceBackgroundSelect; instance++ )
	{
		selectTagId = 'select_background_' + instance;
		if ( $(selectTagId) != null ) { $(selectTagId).selectedIndex = backgroundIndex; }
	}
};

/**
 * get index of selected border color option
 * used to set selectedIndex attr of select tag in module
 * @return 0-based index of border color name
 */
JoomooSitestyle._getBorderColorIndex = function ( givenColorName )
{
	var colorNameIndex = 0;

	for ( var colorName in JoomooSitestyle.borderColorArray )
	{
		if ( colorName == givenColorName )
		{
			break;
		}
		colorNameIndex++;
	}

	return colorNameIndex;
}
/**
 * set page's border color
 */
JoomooSitestyle.setBorderColorName = function ( desiredBorderColorName )
{
	if ( desiredBorderColorName in JoomooSitestyle.borderColorArray )
	{
		JoomooSitestyle.border_color_name = desiredBorderColorName;
	}
	else
	{
		JoomooSitestyle.border_color_name = JoomooSitestyle.default_border_color_name;
	}

	JoomooSitestyle.border_color_value = JoomooSitestyle.borderColorArray[JoomooSitestyle.border_color_name];

	$('page_wrapper').setStyle('border-color', JoomooSitestyle.border_color_value);
	$('header_wrapper').setStyle('border-color', JoomooSitestyle.border_color_value);
	$('simple_pill').setStyle('border-color', JoomooSitestyle.border_color_value);
	$('page_body').setStyle('border-color', JoomooSitestyle.border_color_value);
	$('footer').setStyle('border-color', JoomooSitestyle.border_color_value);

	//
	// some elements are not on all pages
	//
	if ( $('leftcolumn') != null )
	{
		$('leftcolumn').setStyle('border-color', JoomooSitestyle.border_color_value);
	}
	if ( $('maindivider') != null )
	{
		$('maindivider').setStyle('border-color', JoomooSitestyle.border_color_value);
	}
	if ( $('rightcolumn') != null )
	{
		$('rightcolumn').setStyle('border-color', JoomooSitestyle.border_color_value);
	}
	if ( $('border_color_name_for_header') != null )       // defined only on the com_joomoositestyle page
	{
		var colorNameNoUnderlines = JoomooSitestyle.replaceUnderlines ( JoomooSitestyle.border_color_name );
		$('border_color_name_for_header').set('html', ' (' + colorNameNoUnderlines + ')<\/span>');
	}
	if ( $('border_color_name_log') != null )              // defined only on the com_joomoositestyle page
	{
		var colorNameNoUnderlines = JoomooSitestyle.replaceUnderlines ( JoomooSitestyle.border_color_name );
		$('border_color_name_log').set('html', colorNameNoUnderlines + '.<\/span>' );
	}

	/*
	 * we may have multiple instances of the module on a page
	 */
	var colorIndex = JoomooSitestyle._getBorderColorIndex( JoomooSitestyle.border_color_name );
	var selectTagId;
	for ( instance = 0; instance < ViewFunctions.instanceBorderColorSelect; instance++ )
	{
		selectTagId = 'select_border_color_name_' + instance;
		if ( $(selectTagId) != null ) { $(selectTagId).selectedIndex = colorIndex; }
	}
}

/**
 * get index (number) for selected style (string)
 * used to set selectedIndex attr of select tag in module
 * @return 0-based index of border style
 */
JoomooSitestyle._getBorderStyleIndex = function ( givenStyleName )
{
	var styleIndex;
	for ( styleIndex = 0; styleIndex < JoomooSitestyle.borderStyleArray.length; styleIndex++ )
	{
		if ( JoomooSitestyle.borderStyleArray[styleIndex] == givenStyleName )
		{
			break;
		}
	}
	return styleIndex;
}
/**
 * set page's border style
 */
JoomooSitestyle.setBorderStyle = function ( desiredBorderStyle )
{
	JoomooSitestyle.border_style = JoomooSitestyle._verifyBorderStyle ( desiredBorderStyle );

	$('page_wrapper').setStyle('border-style', JoomooSitestyle.border_style);
	$('header_wrapper').setStyle('border-style', JoomooSitestyle.border_style);
	$('simple_pill').setStyle('border-style', JoomooSitestyle.border_style);
	$('page_body').setStyle('border-style', JoomooSitestyle.border_style);
	$('footer').setStyle('border-style', JoomooSitestyle.border_style);

	//
	// some elements are not on all pages:
	//
	if ( $('leftcolumn') != null )
	{
		$('leftcolumn').setStyle('border-style', JoomooSitestyle.border_style);
	}
	if ( $('rightcolumn') != null )
	{
		$('rightcolumn').setStyle('border-style', JoomooSitestyle.border_style);
	}
	if ( $('border_style_for_header') != null )              // defined only on the com_joomoositestyle page
	{
		$('border_style_for_header').set('html', ' (' + JoomooSitestyle.border_style + ')<\/span>');
	}
	if ( $('border_style_log') != null )              // defined only on the com_joomoositestyle page
	{
		$('border_style_log').set( 'html', JoomooSitestyle.border_style + '.<\/span>' );
	}

	/*
	 * we may have multiple instances of the module on a page
	 */
	var styleIndex = JoomooSitestyle._getBorderStyleIndex( JoomooSitestyle.border_style );
	var selectTagId;
	for ( instance = 0; instance < ViewFunctions.instanceBorderStyleSelect; instance++ )
	{
		selectTagId = 'select_border_style_' + instance;
		if ( $(selectTagId) != null ) { $(selectTagId).selectedIndex = styleIndex; }
	}
}
/**
 * set page_wrapper's and other elements' border width
 *
 *  element              min   default   max (width)
 *  ------------------------------------------------
 *  page_wrapper           0      10      30
 *  header_wrapper         0       8      24
 *  simple_pill            0       4      12
 *  leftcolumn             0       4      12
 *  page_body              0       8      24
 *  footer                 0       4      12
 *  rightcolumn            0       4      12
 */
JoomooSitestyle.setBorderWidth = function ( desiredBorderWidth )
{
	var pageWrapperWidth;
	var mediumElementWidth;      // header_wrapper and page_body
	var smallElementWidth;       // simple_pill, leftcolumn, footer, and rightcolumn

	if ( isNaN(desiredBorderWidth) )
	{
		desiredBorderWidth = JoomooSitestyle.default_border_width;
	}
	else if ( desiredBorderWidth < JoomooSitestyle.minimum_border_width )
	{
		desiredBorderWidth = JoomooSitestyle.minimum_border_width;
	}
	else if ( JoomooSitestyle.maximum_border_width < desiredBorderWidth )
	{
		desiredBorderWidth = JoomooSitestyle.maximum_border_width;
	}

	JoomooSitestyle.border_width = desiredBorderWidth;
	pageWrapperWidth = JoomooSitestyle.border_width;
	mediumElementWidth = Math.round( (pageWrapperWidth * 8) / 10 );
	smallElementWidth  = Math.round( (pageWrapperWidth * 4) / 10 );

	// alert( 'JoomooSitestyle.border_width = "' + JoomooSitestyle.border_width + '"' );

	//
	// these are on all pages but still give me errors sometimes so let's play it safe:
	//
	if ( $('page_wrapper')   != null ) { $('page_wrapper').setStyle  ('border-width', JoomooSitestyle.border_width); }
	if ( $('header_wrapper') != null ) { $('header_wrapper').setStyle('border-width', mediumElementWidth); }
	if ( $('simple_pill')    != null ) { $('simple_pill').setStyle   ('border-width', smallElementWidth); }
	if ( $('page_body')      != null ) { $('page_body').setStyle     ('border-width', mediumElementWidth); }
	if ( $('footer')         != null ) { $('footer').setStyle        ('border-width', smallElementWidth); }

	//
	// some elements are not on all pages:
	//
	if ( $('leftcolumn')  != null ) { $('leftcolumn').setStyle ('border-width', smallElementWidth); }
	if ( $('rightcolumn') != null ) { $('rightcolumn').setStyle('border-width', smallElementWidth); }

	if ( $('border_width_for_header') != null )       // defined only on the com_joomoositestyle page
	{
		$('border_width_for_header').set('html', ' (' + JoomooSitestyle.border_width + ')<\/span>');
	}
	if ( $('border_width_log') != null )              // defined only on the com_joomoositestyle page
	{
		$('border_width_log').set('html', JoomooSitestyle.border_width + '.<\/span>' );
	}
	if ( $('select_border_width') != null )           // defined only in the mod_joomoositestyle module
	{
		$('select_border_width').selectedIndex = JoomooSitestyle.border_width;
	}

	//
	// we may have multiple instances of the module on a page
	//
	var widthIndex = JoomooSitestyle.border_width;
	var selectTagId;
	for ( instance = 0; instance < ViewFunctions.instanceBorderWidthSelect; instance++ )
	{
		selectTagId = 'select_border_width_' + instance;
		if ( $(selectTagId) != null ) { $(selectTagId).selectedIndex = widthIndex; }
	}

	var borderWidthForSlider = ( JoomooSitestyle.border_width - JoomooSitestyle.minimum_border_width ) /
			JoomooSitestyle.border_width_increment;
	for ( var instance = 0; instance < ViewFunctions.borderWidthSliders.length; instance++ )
	{
		if ( ViewFunctions.borderWidthSliders[instance] != null )
		{
			ViewFunctions.borderWidthSliders[instance].set(borderWidthForSlider);
		}
	}
};
/**
 * change page's border width
 */
JoomooSitestyle.changeBorderWidth = function ( delta )
{
	var deltaInt;
	var desiredBorderWidthInt;

	deltaInt = parseInt(delta);
	desiredBorderWidthInt = JoomooSitestyle.border_width + deltaInt;
	JoomooSitestyle.setBorderWidth( parseInt(desiredBorderWidthInt) );
}

/**
 * reset all style parameters to default values
 */
JoomooSitestyle.resetAllStyles = function ()
{
	JoomooSitestyle.background        = JoomooSitestyle.default_background;
	JoomooSitestyle.border_color_name = JoomooSitestyle.default_border_color_name;
	JoomooSitestyle.border_style      = JoomooSitestyle.default_border_style;
	JoomooSitestyle.border_width      = JoomooSitestyle.default_border_width;
	JoomooSitestyle.font_size         = JoomooSitestyle.default_font_size;

	JoomooSitestyle.setBackground      ( JoomooSitestyle.background );
	JoomooSitestyle.setBorderColorName ( JoomooSitestyle.border_color_name );
	JoomooSitestyle.setBorderStyle     ( JoomooSitestyle.border_style );
	JoomooSitestyle.setBorderWidth     ( JoomooSitestyle.border_width );
	JoomooSitestyle.setFontSize        ( JoomooSitestyle.font_size );

	JoomooSitestyle.store('all');
}

/**
 * if background is not in array, return default value
 */
JoomooSitestyle._verifyBackground = function ( inputBackground )
{
	if ( inputBackground in JoomooSitestyle.backgroundArray )
	{
		JoomooSitestyle.background = inputBackground;
	}
	else
	{
		JoomooSitestyle.background = JoomooSitestyle.default_background;
	}

	return JoomooSitestyle.background;
}

/**
 * if border_color_name is not in array, return default value
 */
JoomooSitestyle._verifyBorderColorName = function ( inputBorderColorName )
{
	if ( inputBorderColorName in JoomooSitestyle.borderColorArray )
	{
		JoomooSitestyle.border_color_name = inputBorderColorName;
	}
	else
	{
		JoomooSitestyle.border_color_name = JoomooSitestyle.default_border_color_name;
	}

	JoomooSitestyle.border_color_value = JoomooSitestyle.borderColorArray[JoomooSitestyle.border_color_name];
	return JoomooSitestyle.border_color_name;
}

/**
 * if border_style not in array, return default value
 */
JoomooSitestyle._verifyBorderStyle = function ( inputBorderStyle )
{
	var validBorderStyle = JoomooSitestyle.default_border_style;

	for ( var index = 0; index < JoomooSitestyle.borderStyleArray.length; index++ )
	{
		if ( inputBorderStyle == JoomooSitestyle.borderStyleArray[index] )
		{
			validBorderStyle = inputBorderStyle;
			break;
		}
	}

	return validBorderStyle;
}

/**
 * if border_width is not numeric, return default value
 */
JoomooSitestyle._verifyBorderWidth = function ( inputBorderWidth )
{
	if ( isNaN(inputBorderWidth) )
	{
		JoomooSitestyle.border_width = JoomooSitestyle.default_border_width;
	}
	else
	{
		JoomooSitestyle.border_width = inputBorderWidth;
	}

	JoomooSitestyle.border_width = parseInt(JoomooSitestyle.border_width);
	return JoomooSitestyle.border_width;
}

/**
 * if input font_size is not numeric, return default value
 */
JoomooSitestyle._verifyFontSize = function ( inputFontSize )
{
	if ( isNaN(inputFontSize) )
	{
		inputFontSize = JoomooSitestyle.default_font_size;
	}

	JoomooSitestyle.font_size = parseInt(inputFontSize);
	return JoomooSitestyle.font_size;
}

/**
 * get template parameters from DB or cookie
 */
JoomooSitestyle.getJoomooSitestyle = function ()
{
	JoomooSitestyle._joomooSitestyleCookieValue = CookieHandler.getCookieValue( JoomooSitestyle.cookieName );

	if ( JoomooSitestyle._joomooSitestyleCookieValue == null )
	{
		JoomooSitestyle.background        = JoomooSitestyle.default_background;
		JoomooSitestyle.border_color_name = JoomooSitestyle.default_border_color_name;
		JoomooSitestyle.border_style      = JoomooSitestyle.default_border_style;
		JoomooSitestyle.border_width      = JoomooSitestyle.default_border_width;
		JoomooSitestyle.font_size         = JoomooSitestyle.default_font_size;
	}
	else
	{
		//
		// call functions to ensure values are "sane" (numeric or in an array), else use default value
		//
		sitestyle_values = JoomooSitestyle._joomooSitestyleCookieValue.split( JoomooSitestyle.cookieDelimiter );
		JoomooSitestyle.background        = JoomooSitestyle._verifyBackground      ( sitestyle_values[0] );
		JoomooSitestyle.border_color_name = JoomooSitestyle._verifyBorderColorName ( sitestyle_values[1] );
		JoomooSitestyle.border_style      = JoomooSitestyle._verifyBorderStyle     ( sitestyle_values[2] );
		JoomooSitestyle.border_width      = JoomooSitestyle._verifyBorderWidth     ( sitestyle_values[3] );
		JoomooSitestyle.font_size         = JoomooSitestyle._verifyFontSize        ( sitestyle_values[4] );
	}

	// document.write( "JoomooSitestyle.getJoomooSitestyle after setting values: calling JoomooSitestyle._printJoomooSitestyle:<br />\n" );
	// JoomooSitestyle._printJoomooSitestyle();
}
/**
 * print template parameters (for debugging)
 */
JoomooSitestyle._printJoomooSitestyle = function ()
{
	document.write( "JoomooSitestyle._printJoomooSitestyle: JoomooSitestyle._joomooSitestyleCookieValue = " + JoomooSitestyle._joomooSitestyleCookieValue + "<br />\n" );
	document.write( "JoomooSitestyle._printJoomooSitestyle: JoomooSitestyle.background = " + JoomooSitestyle.background + "<br />\n" );
	document.write( "JoomooSitestyle._printJoomooSitestyle: JoomooSitestyle.border_color_value = " + JoomooSitestyle.border_color_value + "<br />\n" );
	document.write( "JoomooSitestyle._printJoomooSitestyle: JoomooSitestyle.border_color_name = " + JoomooSitestyle.border_color_name + "<br />\n" );
	document.write( "JoomooSitestyle._printJoomooSitestyle: JoomooSitestyle.border_style = " + JoomooSitestyle.border_style + "<br />\n" );
	document.write( "JoomooSitestyle._printJoomooSitestyle: JoomooSitestyle.border_width = " + JoomooSitestyle.border_width + "<br />\n" );
	document.write( "JoomooSitestyle._printJoomooSitestyle: JoomooSitestyle.font_size = " + JoomooSitestyle.font_size + "<br />\n" );
}
/**
 * event handler for when template parameters are stored successfully in DB
 */
JoomooSitestyle.storedSuccessfully = function ( responseText )
{
	if ( $('response_text') != null )
	{ $('response_text').set(responseText + '<\/span>' ); }
	if ( $('save_log') != null )
	{ $('save_log').set('html',responseText + '<\/span>' ); }
	JoomooSitestyle.logSavedOk();
}
/**
 * event handler for when template parameters are stored successfully in DB
 */
JoomooSitestyle.logSavedOk = function ( )
{
	var savedDivId;
	var message = 'Saved!';

	for ( var instance = 0; instance < ViewFunctions.instanceSavedDiv; instance++ )
	{
		savedDivId = 'saved_div_' + instance;
		if ( $(savedDivId) != null )
		{
			$(savedDivId).set( 'html', message + '<\/span>' );
		}
	}
	var timeoutSecs = 1.7;
	window.setTimeout( function()
		{
			for ( var instance = 0; instance < ViewFunctions.instanceSavedDiv; instance++ )
			{
				savedDivId = 'saved_div_' + instance;
				$(savedDivId).set('html', ' <\/span>' );
			}
		},
		timeoutSecs * 1000
	);
	JoomooSitestyle.saveJoomooSitestyle();
}
/**
 * event handler called when an error occurs trying to store template parameters are in DB
 */
JoomooSitestyle.storeError = function ( status, statusText )
{
	if ( $('response_text') != null ) { $('response_text').set('html', 'Error ' + status + ': ' + statusText + '<\/span>' ); }
	alert( 'Error ' + status + ': ' + statusText );
};

/**
 * set debug_text_1: private function useful when debugging
 */
JoomooSitestyle._setDebugText1 = function ( text )
{
	if ( $('debug_text_1') != null )
	{ $('debug_text_1').set('html', text + '<\/span>' ); }
}
/**
 * set debug_text_2: private function useful when debugging
 */
JoomooSitestyle._setDebugText2 = function ( text )
{
	if ( $('debug_text_2') != null )
	{ $('debug_text_2').set('html', text + '<\/span>' ); }
}
//
// JoomooSitestyle._url = "/templates/joomoositestyle/requests/helloWorld.php";
JoomooSitestyle._url = "/templates/joomoositestyle/requests/StoreInDatabase.php";
JoomooSitestyle._storageRequest;

/**
 * private function to store template parameters in DB
 * paramName: name of parameter to store;
 * acceptable values = 'all', 'background', 'border_color_name', 'border_style', 'border_width', or 'font_size'
 */
JoomooSitestyle._storeInDatabase = function ( paramName )
{
	var myJoomooRequest;
	var data = {};

	data.id = JoomooSitestyle.id;
	data.save_by_ip = JoomooSitestyle.save_by_ip;

	if ( 0 < data.id && data.save_by_ip == 1 )
	{
		data.ip_address = JoomooSitestyle.ip_address;
	}
	JoomooSitestyle._setDebugText1( 'Hello from JoomooSitestyle._storeInDatabase! paramName = ' + paramName );

	switch ( paramName )
	{
		case 'all':
			data.background = JoomooSitestyle.background;
			data.border_color_name = JoomooSitestyle.border_color_name;
			data.border_style = JoomooSitestyle.border_style;
			data.border_width = JoomooSitestyle.border_width;
			data.font_size = JoomooSitestyle.font_size;
			break;
		case 'background':
			data.background = JoomooSitestyle.background;
			JoomooSitestyle._setDebugText2( 'value = ' + data.background );
			break;
		case 'border_color_name':
			data.border_color_name = JoomooSitestyle.border_color_name;
			JoomooSitestyle._setDebugText2( 'value = ' + data.border_color_name );
			break;
		case 'border_style':
			data.border_style = JoomooSitestyle.border_style;
			JoomooSitestyle._setDebugText2( 'value = ' + data.border_style );
			break;
		case 'border_width':
			data.border_width = JoomooSitestyle.border_width;
			JoomooSitestyle._setDebugText2( 'value = ' + data.border_width );
			break;
		case 'font_size':
			data.font_size = JoomooSitestyle.font_size;
			JoomooSitestyle._setDebugText2( 'value = ' + data.font_size );
			break;
	}

	//
	// Get, setup, and send the request
	// --------------------------------
	//
	myJoomooRequest = new JoomooRequest( JoomooSitestyle._url, JoomooSitestyle.storedSuccessfully, JoomooSitestyle.storeError );

	JoomooSitestyle._storageRequest = myJoomooRequest.sendPostRequest( data );

	return JoomooSitestyle._storageRequest;
}
/**
 * private function to store template parameters in cookie
 */
JoomooSitestyle._storeCookie = function ( paramName )
{
	var message;

	JoomooSitestyle._joomooSitestyleCookieValue = JoomooSitestyle.background        + JoomooSitestyle.cookieDelimiter +
	                      JoomooSitestyle.border_color_name + JoomooSitestyle.cookieDelimiter +
	                      JoomooSitestyle.border_style      + JoomooSitestyle.cookieDelimiter +
	                      JoomooSitestyle.border_width      + JoomooSitestyle.cookieDelimiter +
	                      JoomooSitestyle.font_size;
	CookieHandler.createCookie( JoomooSitestyle.cookieName, JoomooSitestyle._joomooSitestyleCookieValue, 365 );

	if ( $('save_log') != null )
	{
		switch ( paramName )
		{
			case 'all':
				message = 'Values for all parameters saved OK.';
				break;
			case 'background':
				message = 'Value for background (' + JoomooSitestyle.background + ') saved OK.';
				break;
			case 'border_color_name':
				message = 'Value for border color (' + JoomooSitestyle.border_color_name + ') saved OK.';
				break;
			case 'border_style':
				message = 'Value for border style (' + JoomooSitestyle.border_style + ') saved OK.';
				break;
			case 'border_width':
				message = 'Value for border width (' + JoomooSitestyle.border_width + ') saved OK.';
				break;
			case 'font_size':
				message = 'Value for font size  (' + JoomooSitestyle.font_size + ') saved OK.';
				break;
		}
		$('save_log').set('html', message + '<\/span>' );
	}

	if ( $('save_log') != null ) { $('save_log').set('html', message + '<\/span>' ); }
	JoomooSitestyle.logSavedOk();
}
/**
 * store template parameters in DB or cookie
 * paramName: name of parameter to store;
 * acceptable values = 'background', 'border_color_name', 'border_style', 'border_width', 'font_size', or 'all'
 */
JoomooSitestyle.store = function ( paramName )
{
	if ( JoomooSitestyle.usingDb )
	{
		JoomooSitestyle._storeInDatabase( paramName );
	}
	else
	{
		if ( $('save_log') != null ) { $('save_log').set('html', 'Hello world 2.<\/span>' ); }
		JoomooSitestyle._storeCookie( paramName );
		JoomooSitestyle.saveJoomooSitestyle();
	}
}

/**
 * save template parameters (from DB or cookie) so we know if they've changed later
 * for mouse out event of various modules created (sliders don't always get the mouse up event!)
 */
JoomooSitestyle.saveJoomooSitestyle = function ()
{
	if ( ! JoomooSitestyle.savedParams ) { JoomooSitestyle.savedParams = {}; }

	JoomooSitestyle.savedParams.background        = JoomooSitestyle.background;
	JoomooSitestyle.savedParams.border_color_name = JoomooSitestyle.border_color_name;
	JoomooSitestyle.savedParams.border_style      = JoomooSitestyle.border_style;
	JoomooSitestyle.savedParams.border_width      = JoomooSitestyle.border_width;
	JoomooSitestyle.savedParams.font_size         = JoomooSitestyle.font_size;
}
JoomooSitestyle.saveJoomooSitestyle();
/**
 * returns true if user has changed parameters since the last time they were changed
 * for mouse out event of various modules created (sliders don't always get the mouse up event!)
 */
JoomooSitestyle.parametersUnchanged = function ()
{
	if ( ( JoomooSitestyle.savedParams.background        != null && JoomooSitestyle.savedParams.background        == JoomooSitestyle.background        ) &&
	     ( JoomooSitestyle.savedParams.border_color_name != null && JoomooSitestyle.savedParams.border_color_name == JoomooSitestyle.border_color_name ) &&
	     ( JoomooSitestyle.savedParams.border_style      != null && JoomooSitestyle.savedParams.border_style      == JoomooSitestyle.border_style      ) &&
	     ( JoomooSitestyle.savedParams.border_width      != null && JoomooSitestyle.savedParams.border_width      == JoomooSitestyle.border_width      ) &&
	     ( JoomooSitestyle.savedParams.font_size         != null && JoomooSitestyle.savedParams.font_size         == JoomooSitestyle.font_size         )    )
	{
		return true;
	}

	return false;
}
