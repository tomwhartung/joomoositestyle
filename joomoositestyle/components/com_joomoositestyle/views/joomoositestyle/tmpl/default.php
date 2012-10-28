<?php
/**
 * @version     $Id: default.php,v 1.56 2009/05/19 16:06:01 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */
?>
<?php defined('_JEXEC') or die('Restricted access'); ?>

<a name="component_top" id="component_top"></a>
<?php if ( $this->params->get( 'show_page_title' ) ) : ?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
 <?php echo $this->params->get( 'page_title' ); ?>
</div>
<?php endif; ?>

<style>
div#response_text, div#debug_text_1, div#debug_text_2
{
   border: solid 1px white;
   margin: 4px;
   padding: 4px;
}
</style>

<p class="joomoositestyle">
 Use this page to change the appearance of the site.
 Click on style category's header to expose its options, or
 <span class="joomoositestyle_control" id="reset_all_styles">click here to reset all</span>
 styles to their default values.
</p>
<script type="text/javascript">
  $('reset_all_styles').addEvent('click', function(e) { JoomooSitestyle.resetAllStyles(); });
</script>

<p class="joomoositestyle">
 This page saves your preferences in a
 <script type="text/javascript">JoomooSitestyle.usingDb ? document.write('database.') : document.write('cookie.');</script>
</p>
<p class="joomoositestyle">
 <span id="save_log"></span>
</p>
<?php
  // print '<div id="response_text">response_text div here, waiting for you to click...</div>' . "\n";
  // print '<div id="debug_text_1">debug_text_1 div here...</div>' . "\n";
  // print '<div id="debug_text_2">debug_text_2 div here...</div>' . "\n";
?>

<noscript>
 <div class="noscript">
  <p class="noscript">
   You have javascript disabled in your browser.
   This is unfortunate, because this page requires javascript to make these changes.
  </p>
  <p class="noscript">
   To activate the controls on this page, use your browser's Preferences... option to enable javascript for this site.
  </p>
 </div>
</noscript>

<div id="accordion">
  <h4 class="toggler" id="font_size_head">
   <a name="change_font_size" id="change_font_size">Change Font Size
    <span class="current_value" id="font_size_for_header">
     <script type="text/javascript">document.write( "(" + JoomooSitestyle.font_size + "%)");</script>
    </span>
   </a>
  </h4>
  <div class="element">
    <p class="joomoositestyle">
     The current font size is
     <span class="current_value" id="font_size_log">
      <script type="text/javascript">document.write( JoomooSitestyle.font_size + "%.");</script>
     </span>
     Use the dropdown list to set it directly or change it by clicking on a value in the table below.
    </p>
    <table class="font_size" cellpadding="0" cellspacing="0">
      <tr>
       <th class="font_size">Font Size</th>
       <th class="font_size" colspan="3">Increase By</th>
       <th class="font_size" colspan="3">Decrease By</th>
       <th class="font_size" rowspan="2">
        <span class="joomoositestyle_control" id='reset_font_size'>Reset
         <script type="text/javascript">
            document.write( "to " + JoomooSitestyle.default_font_size + "%" );
         </script>
        </span>
       </td>
      </tr>
     <tr>
      <td class="font_size_left">
       <script type="text/javascript">ViewFunctions.printFontSizeSelect();</script>
      </td>
      <td class="font_size_left" style="font-size: 115%;">
       <span class="joomoositestyle_control" id="increase_font_size_15_percent">+15%</span>
      </td>
      <td class="font_size_center" style="font-size: 110%;">
       <span class="joomoositestyle_control" id="increase_font_size_10_percent">+10%</span>
      </td>
      <td class="font_size_right" style="font-size: 105%;">
       <span class="joomoositestyle_control" id="increase_font_size_5_percent">+5%</span>
      </td>
      <td class="font_size_left" style="font-size: 95%;">
       <span class="joomoositestyle_control" id="decrease_font_size_5_percent">-5%</span>
      </td>
      <td class="font_size_center" style="font-size: 90%;">
       <span class="joomoositestyle_control" id="decrease_font_size_10_percent">-10%</span>
      </td>
      <td class="font_size_right" style="font-size: 85%;">
       <span class="joomoositestyle_control" id="decrease_font_size_15_percent">-15%</span>
      </td>
     </tr>
    </table>
    <p class="joomoositestyle">
     The minimum font size is
     <span class="joomoositestyle_control" id="minimize_font_size">
      <script type="text/javascript">document.write( JoomooSitestyle.minimum_font_size + "%");</script>
     </span>
     and the maximum is
     <span class="joomoositestyle_control" id="maximize_font_size">
      <script type="text/javascript">document.write( JoomooSitestyle.maximum_font_size + "%.");</script>
     </span>
    </p>
  </div>
  <script type="text/javascript">
    $('increase_font_size_5_percent').addEvent ('click', function(e) { JoomooSitestyle.changeFontSize(  5 ); JoomooSitestyle.store('font_size'); });
    $('increase_font_size_10_percent').addEvent('click', function(e) { JoomooSitestyle.changeFontSize( 10 ); JoomooSitestyle.store('font_size'); });
    $('increase_font_size_15_percent').addEvent('click', function(e) { JoomooSitestyle.changeFontSize( 15 ); JoomooSitestyle.store('font_size'); });
    $('decrease_font_size_5_percent').addEvent ('click', function(e) { JoomooSitestyle.changeFontSize( -5 ); JoomooSitestyle.store('font_size'); });
    $('decrease_font_size_10_percent').addEvent('click', function(e) { JoomooSitestyle.changeFontSize(-10 ); JoomooSitestyle.store('font_size'); });
    $('decrease_font_size_15_percent').addEvent('click', function(e) { JoomooSitestyle.changeFontSize(-15 ); JoomooSitestyle.store('font_size'); });
    $('reset_font_size').addEvent('click', function(e) { JoomooSitestyle.setFontSize( JoomooSitestyle.default_font_size ); JoomooSitestyle.store('font_size'); });
    $('minimize_font_size').addEvent('click', function(e) {
        JoomooSitestyle.setFontSize( JoomooSitestyle.minimum_font_size ); JoomooSitestyle.store('font_size');
    });
    $('maximize_font_size').addEvent('click', function(e) {
        JoomooSitestyle.setFontSize( JoomooSitestyle.maximum_font_size ); JoomooSitestyle.store('font_size');
    });
  </script>

  <h4 class="toggler" id="background_head">
   <a name="change_background" id="change_background">Change Background
    <span class="current_value" id="background_for_header">
     <script type="text/javascript">
      document.write( " (" + JoomooSitestyle.replaceUnderlines(JoomooSitestyle.background) + ")" );
     </script>
    </span>
   </a>
  </h4>
  <div class="element">
    <p class="joomoositestyle">
     The current background is
     <span class="current_value" id="background_log">
      <script type="text/javascript">document.write( JoomooSitestyle.replaceUnderlines(JoomooSitestyle.background) + "." );</script>
     </span>
     Use the dropdown list to set it directly, change it by clicking on a color in the table below, or
     <span class="joomoositestyle_control" id="reset_background">click here to reset it</span>
     to the default value
     <script type="text/javascript">document.write( "(" + JoomooSitestyle.default_background + ")." );</script>
    </p>
    <p class="joomoositestyle">
     <div class="joomoositestyle_select" style="margin-left: 40px;">
      Background:&nbsp;<script type="text/javascript">ViewFunctions.printBackgroundSelect();</script>
     </div>
    </p>
    <p class="joomoositestyle">
     <script type="text/javascript">ViewFunctions.printBackgroundTable();</script>
    </p>
  </div>

  <h4 class="toggler" id="border_color_head">
   <a name="change_border_color" id="change_border_color">Change Border Color
    <span class="current_value" id="border_color_name_for_header">
     <script type="text/javascript">
      document.write( " (" + JoomooSitestyle.replaceUnderlines(JoomooSitestyle.border_color_name) + ")" );
     </script>
    </span>
   </a>
  </h4>
  <div class="element">
    <p class="joomoositestyle">
     The current border color is
     <span class="current_value" id="border_color_name_log">
      <script type="text/javascript">document.write( JoomooSitestyle.replaceUnderlines(JoomooSitestyle.border_color_name) + "." );</script>
     </span>
     Use the dropdown list to set it directly, change it by clicking on a color in the table
     <script type="text/javascript">
      if ( JoomooSitestyle.border_color_name == JoomooSitestyle.default_border_color_name )
      {
        document.write( "below.\n" );
      }
      else
      {
        document.write( "below, or\n" );
        document.write( "<span class='joomoositestyle_control' id='reset_border_color_name'>click here to reset it</span>\n" );
        document.write( "to the default value (" + JoomooSitestyle.default_border_color_name + ")." );
      }
     </script>
    </p>
    <p class="joomoositestyle">
     <div class="joomoositestyle_select" style="margin-left: 40px;">
      Border&nbsp;Color:&nbsp;<script type="text/javascript">ViewFunctions.printBorderColorSelect();</script>
     </div>
    </p>
    <script type="text/javascript">ViewFunctions.printBorderColorTable();</script>
  </div>
  <script type="text/javascript">
    if ( $('reset_border_color_name') != null )
    {
      $('reset_border_color_name').addEvent('click', function(e) {
          JoomooSitestyle.setBorderColorName( JoomooSitestyle.default_border_color_name ); JoomooSitestyle.store('border_color_name');
      });
    }
  </script>

  <h4 class="toggler" id="border_style_head">
   <a name="change_border_style" id="change_border_style">Change Border Style
    <span class="current_value" id="border_style_for_header">
     <script type="text/javascript">document.write( " (" + JoomooSitestyle.border_style + ")" );</script>
    </span>
   </a>
  </h4>
  <div class="element">
    <p class="joomoositestyle">
     The current border style is
     <span class="current_value" id="border_style_log">
      <script type="text/javascript">document.write( JoomooSitestyle.border_style + "." );</script>
     </span>
     Change it by clicking on a value in the table
     <script type="text/javascript">
      if ( JoomooSitestyle.border_style == JoomooSitestyle.default_border_style )
      {
        document.write( "below.\n" );
      }
      else
      {
        document.write( "below, or\n" );
        document.write( "<span class='joomoositestyle_control' id='reset_border_style'>click here to reset it</span>\n" );
        document.write( "to the default value (" + JoomooSitestyle.default_border_style + ")." );
      }
     </script>
    </p>
    <p class="joomoositestyle">
     <div class="joomoositestyle_select" style="margin-left: 40px;">
      Border&nbsp;Style:&nbsp;<script type="text/javascript">ViewFunctions.printBorderStyleSelect();</script>
     </div>
     <script type="text/javascript">ViewFunctions.printBorderStyleTable();</script>
    </p>
    <p class="joomoositestyle">
     The groove, inset, and double styles look best with thicker borders, and
     the dashed and dotted styles look best with thinner borders.
    </p>
  </div>
  <script type="text/javascript">
    if ( $('reset_border_style') != null )
    {
      $('reset_border_style').addEvent('click',  function(e) {
        JoomooSitestyle.setBorderStyle( JoomooSitestyle.default_border_style ); JoomooSitestyle.store('border_style');
      });
    }
  </script>

  <h4 class="toggler" id="border_width_head">
   <a name="change_border_width" id="change_border_width">Change Border Width
    <span class="current_value" id="border_width_for_header">
     <script type="text/javascript">document.write( " (" + JoomooSitestyle.border_width + ")");</script>
    </span>
   </a>
  </h4>
  <div class="element">
    <p class="joomoositestyle">
     The current border width is
     <span class="current_value" id="border_width_log">
      <script type="text/javascript">document.write( JoomooSitestyle.border_width + ".");</script>
     </span>
     Use the dropdown list to set the border width directly, or change it by clicking on a value in the table below.
    </p>
    <table class="change_border_width" cellpadding="0" cellspacing="0">
     <tr>
      <th class="change_border_width">Border Width</th>
      <th class="change_border_width" colspan="5">Decrease By (pixels)</th>
      <th class="change_border_width" colspan="5">Increase By (pixels)</th>
      <th class="change_border_width" rowspan="2">
       <a href="#component_to" id="reset_border_width">Reset<br />
        <script type="text/javascript">
         document.write( "to " + JoomooSitestyle.default_border_width );
        </script>
        pixels
       </a>
      </th>
      </tr>
     <tr>
      <td class="change_border_width_left">
       <script type="text/javascript">ViewFunctions.printBorderWidthSelect();</script>
      </td>
      <td class="change_border_width_left"><span class="joomoositestyle_control" id="decrease_border_width_5">-5</span></td>
      <td class="change_border_width_center"><span class="joomoositestyle_control" id="decrease_border_width_4">-4</span></td>
      <td class="change_border_width_center"><span class="joomoositestyle_control" id="decrease_border_width_3">-3</span></td>
      <td class="change_border_width_center"><span class="joomoositestyle_control" id="decrease_border_width_2">-2</span></td>
      <td class="change_border_width_right"><span class="joomoositestyle_control" id="decrease_border_width_1">-1</span></td>
      <td class="change_border_width_left"><span class="joomoositestyle_control" id="increase_border_width_1">+1</span></td>
      <td class="change_border_width_center"><span class="joomoositestyle_control" id="increase_border_width_2">+2</span></td>
      <td class="change_border_width_center"><span class="joomoositestyle_control" id="increase_border_width_3">+3</span></td>
      <td class="change_border_width_center"><span class="joomoositestyle_control" id="increase_border_width_4">+4</span></td>
      <td class="change_border_width_right"><span class="joomoositestyle_control" id="increase_border_width_5">+5</span></td>
     </tr>
    </table>
    <p class="joomoositestyle">
     Thicker borders look best with the groove, inset, and double styles, and
     thinner borders look best with the dashed and dotted styles.
    </p>
    <script type="text/javascript">// ViewFunctions.printBorderWidthTable();</script>
  </div>
  <script type="text/javascript">
    $('increase_border_width_1').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth( 1); JoomooSitestyle.store('border_width'); });
    $('increase_border_width_2').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth( 2); JoomooSitestyle.store('border_width'); });
    $('increase_border_width_3').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth( 3); JoomooSitestyle.store('border_width'); });
    $('increase_border_width_4').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth( 4); JoomooSitestyle.store('border_width'); });
    $('increase_border_width_5').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth( 5); JoomooSitestyle.store('border_width'); });
    $('decrease_border_width_1').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth(-1); JoomooSitestyle.store('border_width'); });
    $('decrease_border_width_2').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth(-2); JoomooSitestyle.store('border_width'); });
    $('decrease_border_width_3').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth(-3); JoomooSitestyle.store('border_width'); });
    $('decrease_border_width_4').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth(-4); JoomooSitestyle.store('border_width'); });
    $('decrease_border_width_5').addEvent('click', function(e) { JoomooSitestyle.changeBorderWidth(-5); JoomooSitestyle.store('border_width'); });
    $('reset_border_width').addEvent('click', function(e) {
        JoomooSitestyle.setBorderWidth( JoomooSitestyle.default_border_width ); JoomooSitestyle.store('border_width')
    });
  </script>
</div>

<script type="text/javascript">
	var myAccordion = new Accordion($('accordion'), 'h4.toggler', 'div.element', {
		opacity: false,
		show: 0,   // needed for IE
		onActive: function(toggler, element)
		{
			toggler.setStyle( 'color', JoomooSitestyle.heading_color );   // set in index.php to one of the heading_* colors
		},
		onBackground: function(toggler, element)
		{
			toggler.setStyle( 'color', JoomooSitestyle.link_color );      // set in index.php to one of the link_* colors
		}
	}, $('accordion'));
//	$('font_size_head').setStyle( 'color', JoomooSitestyle.link_color );
	$('background_head').setStyle( 'color', JoomooSitestyle.link_color );
	$('border_color_head').setStyle( 'color', JoomooSitestyle.link_color );
	$('border_style_head').setStyle( 'color', JoomooSitestyle.link_color );
	$('border_width_head').setStyle( 'color', JoomooSitestyle.link_color );
</script>

<h4 class="joomoositestyle">How It Works</h4>
<p class="joomoositestyle">
 <?php
  echo "This page uses the\n";
  echo JHTML::_( 'link',
                 'http://mootools.net',
                 'mootools JavaScript framework',
                 array( 'target' => '_blank', 'title' => 'mootools.net home page' )
                );
  echo " to make these changes immediately on the current page with out having to reload it.\n";
  echo "Mootools also makes the accordion effect possible -\n";
  echo "this is what makes only one group of options visible at a time.\n";
  echo "This page also uses\n";
  echo JHTML::_( 'link',
                 'http://developer.mozilla.org/en/docs/JavaScript',
                 'JavaScript',
                 array('target' => '_blank', 'title' => 'JavaScript page at mozilla.org')
               );
  echo " to save these options as\n";
  echo JHTML::_( 'link',
                 'http://en.wikipedia.org/wiki/HTTP_cookie',
                 'cookies',
                 array( 'target' => '_blank', 'title' => 'Definition of HTTP cookie at wikipedia.org' )
               );
  echo " in your browser for up to a year.\n";
  echo "</p>";
 ?>
