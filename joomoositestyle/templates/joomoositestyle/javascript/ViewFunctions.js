/**
 * @version     $Id: ViewFunctions.js,v 1.22 2009/05/19 16:42:01 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

/*
 * ViewFunctions.js: functions to support views shared by component(s) and module(s)
 * Note:
 *    There is also a file named
 *       components/com_joomoositestyle/javascript/ViewFunctions.js
 *    that contains component-specific ViewFunctions
 */
var ViewFunctions;
if ( ! ViewFunctions ) { ViewFunctions = {}; }

/**
 * print div tag and create events to monitor when mouse goes up
 * this is for the sliders: we don't want to track the values & continually save them to DB
 *    and sometimes dynamic growth of page causes slider to not save value
 */
ViewFunctions.instanceModuleDivTag = 0;
ViewFunctions.printModuleOpenDivTag = function ( )
{
	var divTagId;

	divTagId = 'mod_joomoositestyle_' + ViewFunctions.instanceModuleDivTag++;
	document.write( '<div class="mod_joomoositestyle" id="' + divTagId + '">' );
	$(divTagId).addEvent( 'mouseout',
		function (e) { if ( ! JoomooSitestyle.parametersUnchanged() ) { JoomooSitestyle.store('all'); } }
	);
	$(divTagId).addEvent( 'mouseup',
		function (e) { if ( ! JoomooSitestyle.parametersUnchanged() ) { JoomooSitestyle.store('all'); } }
	);
}
ViewFunctions.printModuleCloseDivTag = function ( )
{
	document.write(' </div>');
}

/**
 * print select tag with options for setting font size and add event to process changes
 */
ViewFunctions.instanceFontSizeSelect = 0;
ViewFunctions.printFontSizeSelect = function ( )
{
	var selectId;    // id attribute for select tag
	var selected;    // selected attribute for option tags

	selectId = 'select_font_size_' + ViewFunctions.instanceFontSizeSelect++;
	document.write( '<select class="joomoositestyle_select" id="' + selectId + '">' );

	for ( var percentage = JoomooSitestyle.minimum_font_size;
	          percentage <= JoomooSitestyle.maximum_font_size;
	          (percentage += JoomooSitestyle.font_size_increment) )
	{
		percentage == JoomooSitestyle.font_size ? selected = 'selected="selected"' : selected = '';
		document.write( '<option class="joomoositestyle_option" value="' + percentage + '" ' + selected + '>'  );
		document.write( percentage + '%' );
		document.write( '</option>' );
	}

	document.write( '</select>' );

	$(selectId).addEvent('change', function(e) {
		var desiredFontSize = Math.round( JoomooSitestyle.minimum_font_size +
			($(selectId).selectedIndex * JoomooSitestyle.font_size_increment) );
		JoomooSitestyle.setFontSize(desiredFontSize);
		JoomooSitestyle.store('font_size');
	} );
}
/**
 * print mootools slider allowing user to set font size and add event to process changes
 */
ViewFunctions.instanceFontSizeSlider = 0;
ViewFunctions.fontSizeSliders = new Array();
ViewFunctions.printFontSizeSlider = function ( )
{
	var sliderInstance = ViewFunctions.instanceFontSizeSlider;
	var sizeId   = 'current_font_size_' + ViewFunctions.instanceFontSizeSlider;
	var knobId   = 'font_size_knob_'    + ViewFunctions.instanceFontSizeSlider;
	var sliderId = 'font_size_slider_'  + ViewFunctions.instanceFontSizeSlider++;

	document.write( '  <div id="' + sliderId + '" class="joomoositestyle_slider">' );
	document.write( '    <div id="' + knobId + '" class="font_size_knob"></div>' );
	document.write( '  </div>' );

	// Create the new slider instance
	var fontSizeSlider = $(sliderId);
	var fontSizeSteps = ( JoomooSitestyle.maximum_font_size - JoomooSitestyle.minimum_font_size ) /
		JoomooSitestyle.font_size_increment;
	var initialFontSize = ( JoomooSitestyle.font_size - JoomooSitestyle.minimum_font_size ) /
		JoomooSitestyle.font_size_increment;
	//
	// IE requires that we do this only after dom is ready (I know!!)
	//
	window.addEvent('domready', function(){
		// ViewFunctions.fontSizeSliders[sliderInstance] = new Slider( $('font_size_slider_0'), $('font_size_knob_0'), {
		ViewFunctions.fontSizeSliders[sliderInstance] = new Slider( $(sliderId), $(knobId), {
			steps: 18,
			offset: -5,
			onChange: function(rawValue){
				var percentage;
				intValue = parseInt(rawValue);
				isNaN(intValue) ? percentage = JoomooSitestyle.default_font_size :
				                  percentage = JoomooSitestyle.minimum_font_size + ( intValue * JoomooSitestyle.font_size_increment );
				JoomooSitestyle.setFontSize(percentage);
				$(sizeId).set('html', percentage + '%)</span>');
			//	$('fs_debug').set( 'html', 'percentage = "' + percentage + '"</span>' );
			}
		}).set(initialFontSize);
	//	}).set(0);
	});

	$(sliderId).addEvent( 'mouseup', function (e) { JoomooSitestyle.store('font_size'); } );
}

/**
 * get background color name for given array index
 * @return 0-based index of border color name
 */
ViewFunctions._getBackgroundForIndex = function ( givenIndex )
{
	var colorIndex = 0;
	var background;

	for ( background in JoomooSitestyle.backgroundArray )
	{
		if ( colorIndex == givenIndex )
		{
			break;
		}
		colorIndex++;
	}

	return background;
}
/**
 * print table with options for setting background
 */
ViewFunctions.instanceBackgroundSelect = 0;
ViewFunctions.printBackgroundSelect = function ( )
{
	var selectId;    // id attribute for select tag
	var selected;    // selected attribute for option tags
	var backgroundNoUnderlines;

	selectId = 'select_background_' + ViewFunctions.instanceBackgroundSelect++;
	document.write( '<select class="joomoositestyle_select" id="' + selectId + '">' );

	for ( var background in JoomooSitestyle.backgroundArray )
	{
		backgroundNoUnderlines = JoomooSitestyle.replaceUnderlines( background );
		background == JoomooSitestyle.background ? selected = 'selected="selected"' : selected = '';
		document.write( '<option class="joomoositestyle_option" value="' + background + '" ' + selected + '>' );
		document.write( backgroundNoUnderlines );
		document.write( '</option>' );
	}

	document.write( '</select>' );

	$(selectId).addEvent('change', function(e) {
		var selectedIndex = $(selectId).selectedIndex;
		var selectedColor = ViewFunctions._getBackgroundForIndex(selectedIndex);
		JoomooSitestyle.setBackground(selectedColor);
		JoomooSitestyle.store('background');
	} );
}

/**
 * get color name for given array index
 * @return 0-based index of border color name
 */
ViewFunctions._getBorderColorForIndex = function ( givenIndex )
{
	var colorIndex = 0;
	var colorName;

	for ( colorName in JoomooSitestyle.borderColorArray )
	{
		if ( colorIndex == givenIndex )
		{
			break;
		}
		colorIndex++;
	}

	return colorName;
}
/**
 * print select tag with options for setting border color and add event to process changes
 */
ViewFunctions.instanceBorderColorSelect = 0;
ViewFunctions.printBorderColorSelect = function ( )
{
	var selectId;    // id attribute for select tag
	var selected;    // selected attribute for option tags
	var colorNameNoUnderlines;

	selectId = 'select_border_color_name_' + ViewFunctions.instanceBorderColorSelect++;
	document.write( '<select class="joomoositestyle_select" id="' + selectId + '">' );

	for ( var colorName in JoomooSitestyle.borderColorArray )
	{
		colorNameNoUnderlines = JoomooSitestyle.replaceUnderlines( colorName );
		colorName == JoomooSitestyle.border_color_name ? selected = 'selected="selected"' : selected = '';
		document.write( '<option class="joomoositestyle_option" value="' + colorName + '" ' + selected + '>' );
		document.write( colorNameNoUnderlines );
		document.write( '</option>' );
	}

	document.write( '</select>' );

	$(selectId).addEvent('change', function(e) {
		var selectedIndex = $(selectId).selectedIndex;
		var selectedColor = ViewFunctions._getBorderColorForIndex(selectedIndex);
		JoomooSitestyle.setBorderColorName(selectedColor);
		JoomooSitestyle.store('border_color_name');
	} );
}

/**
 * print select tag with options for setting border style and add event to process changes
 */
ViewFunctions.instanceBorderStyleSelect = 0;
ViewFunctions.printBorderStyleSelect = function ( )
{
	var style;       // style currently being processed
	var selectId;    // id attribute for select tag
	var selected;    // selected attribute for option tags

	selectId = 'select_border_style_' + ViewFunctions.instanceBorderStyleSelect++;
	document.write( '<select class="joomoositestyle_select" id="' + selectId + '">' );

	for ( var index = 0; index < JoomooSitestyle.borderStyleArray.length; index++ )
	{
		style = JoomooSitestyle.borderStyleArray[index];
		style == JoomooSitestyle.border_style ? selected = 'selected="selected"' : selected = '';
		document.write( '<option class="joomoositestyle_option" value="' + style + '" ' + selected + '>' );
		document.write( style );
		document.write( '</option>' );
	}

	document.write( '</select>' );

	$(selectId).addEvent('change', function(e) {
		var selectedIndex = $(selectId).selectedIndex;
		var selectedValue = JoomooSitestyle.borderStyleArray[selectedIndex];
		JoomooSitestyle.setBorderStyle(selectedValue);
		JoomooSitestyle.store('border_style');
	} );
}

/**
 * print select tag with options for setting border width and add event to process changes
 * Note: we assume the border width is the same as the index to the option
 */
ViewFunctions.instanceBorderWidthSelect = 0;
ViewFunctions.printBorderWidthSelect = function ( )
{
	var selectId;    // id attribute for select tag
	var selected;    // selected attribute for option tags

	selectId = 'select_border_width_' + ViewFunctions.instanceBorderWidthSelect++;
	document.write( '<select class="joomoositestyle_select" id="' + selectId + '">' );

	for ( var width = JoomooSitestyle.minimum_border_width;
	          width <= JoomooSitestyle.maximum_border_width;
	          (width += JoomooSitestyle.border_width_increment) )
	{
		width == JoomooSitestyle.border_width ? selected = 'selected="selected"' : selected = '';
		document.write( '<option class="joomoositestyle_option" value="' + width + '" ' + selected + '>'  );
		document.write( width + 'px' );
		document.write( '</option>' );
	}

	document.write( '</select>' );

	$(selectId).addEvent('change', function(e) {
		// alert( 'selectId = ' + selectId + '; $(selectId).selectedIndex = ' + $(selectId).selectedIndex );
		JoomooSitestyle.setBorderWidth($(selectId).selectedIndex);
		JoomooSitestyle.store('border_width');
	} );
}
/**
 * print mootools slider allowing user to set border width and add event to process changes
 */
ViewFunctions.instanceBorderWidthSlider = 0;
ViewFunctions.borderWidthSliders = new Array();
ViewFunctions.printBorderWidthSlider = function ( )
{
	var sliderInstance = ViewFunctions.instanceBorderWidthSlider;
	var widthId  = 'current_border_width_' + ViewFunctions.instanceBorderWidthSlider;
	var knobId   = 'border_width_knob_'    + ViewFunctions.instanceBorderWidthSlider;
	var sliderId = 'border_width_slider_'  + ViewFunctions.instanceBorderWidthSlider++;

	document.write( '  <div id="' + sliderId + '" class="joomoositestyle_slider">' );
	document.write( '    <div id="' + knobId + '" class="border_width_knob"></div>' );
	document.write( '  </div>' );

	// Create the new slider instance
	var borderWidthSlider = $(sliderId);
	var borderWidthSteps = ( JoomooSitestyle.maximum_border_width - JoomooSitestyle.minimum_border_width ) /
		JoomooSitestyle.border_width_increment;
	var initialBorderWidth = ( JoomooSitestyle.border_width - JoomooSitestyle.minimum_border_width ) /
		JoomooSitestyle.border_width_increment;
	//
	// IE requires that we do this only after dom is ready (I know!!)
	//
	window.addEvent('domready', function(){
		ViewFunctions.borderWidthSliders[sliderInstance] = new Slider(
			borderWidthSlider,
			borderWidthSlider.getElement('.border_width_knob'),
			{
				steps: borderWidthSteps,
				offset: -5,
				onChange: function(value){
					var pixels = JoomooSitestyle.minimum_border_width + ( value * JoomooSitestyle.border_width_increment );
					JoomooSitestyle.setBorderWidth(pixels);
				//	$('bw_debug').set('html', 'value = ' + value + '</span>');
					$(widthId).set('html', pixels + 'px)</span>');
				}
			}
		).set(initialBorderWidth);
	//	).set(0);
	//	ViewFunctions.borderWidthSliders[sliderInstance].set(0);
	//	$(knobId).setStyle( 'margin-left', 0 );
	});

	$(knobId).addEvent( 'mouseup', function (e) { JoomooSitestyle.store('border_width'); });
	$(sliderId).addEvent( 'mouseup', function (e) { JoomooSitestyle.store('border_width'); });
}

/**
 * print tag allowing user to reset all options to defaults
 */
ViewFunctions.instanceResetAll = 0;
ViewFunctions.printResetAll = function ( )
{
	var resetAllId;    // id attribute for tag

	resetAllId = 'reset_all_' + ViewFunctions.instanceResetAll++;
	document.write( '<button class="mod_joomoositestyle_reset_all" id="' + resetAllId + '" value="Reset">Reset All Styles</button>' );

	$(resetAllId).addEvent('click', function(e) {
		JoomooSitestyle.resetAllStyles();
		JoomooSitestyle.store('all');
	} );
}

/**
 * print tag to display when the parms have been stored OK
 */
ViewFunctions.instanceSavedDiv = 0;
ViewFunctions.printSavedDiv = function ( )
{
	var savedDivId;    // id attribute for tag

	savedDivId = 'saved_div_' + ViewFunctions.instanceSavedDiv++;
	document.write( '<span id="' + savedDivId + '"></span>' );
}
