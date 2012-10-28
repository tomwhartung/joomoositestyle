<?php
/**
 * @version     $Id: index.php,v 1.77 2009/05/21 19:51:13 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  JoomooSitestyle
 * @copyright   Copyright (C) 2008-2011 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
 <jdoc:include type="head" />        <!-- includes meta, title, script tags, etc. -->
 <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
 <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
 <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

 <!-- Added for google.com (groja.com) -->
 <!-- <meta name="google-site-verification" content="MKqYswurAlS9Vh-9URWhQiiLulxAjEzdXeCiX86xcgQ" /> -->
 <!-- Added for google.com (seeourminds.com) -->
 <meta name="google-site-verification" content="N7jBLSPdP6o5Hk4zUIsWqyKz_Gd-J5O0_Xm5omxKqmM" />
 <!-- Added for google.com (tomhartung.com) -->
 <!-- <meta name="google-site-verification" content="gqlekLjnnakFZf4zuiXiN3LnUBe18Kpaxwi1b9X_FQc" /> -->
 <?php
   $this->addScript( 'media' .DS. 'system' .DS. 'js' .DS. 'mootools-core.js');
   $this->addScript( 'media' .DS. 'system' .DS. 'js' .DS. 'mootools-more.js');
   $this->addScript( 'components' .DS. 'com_joomoobase' .DS. 'javascript' .DS. 'CookieHandler.js');
   $this->addScript( 'templates' .DS. $this->template .DS. 'javascript' .DS. 'JoomooSiteStyle.js');
   $this->addScript( 'templates' .DS. $this->template .DS. 'javascript' .DS. 'ViewFunctions.js');
   //
   // get the params set in the backend ("$this" is a JDocumentHTML object)
   //
   $heading_color = $this->params->get('heading_color');
   $link_color = $this->params->get('link_color');
   $bullet_color = $this->params->get('bullet_color');
   $input_color = $this->params->get('input_color');
   $site_name = $this->params->get('site_name');
   $tag_line_above = $this->params->get('tag_line_above');
   $tag_line_below = $this->params->get('tag_line_below');
   $save_by_ip = $this->params->get('save_by_ip');
   $default_background = $this->params->get('default_background');
   $default_border_color_name = $this->params->get('default_border_color_name');
   $default_border_style = $this->params->get('default_border_style');
   $default_border_width = $this->params->get('default_border_width');
   $default_font_size = $this->params->get('default_font_size');
   //
   // create a dbController that knows how to use db to set and retrieve param values
   //
   require_once ( 'assets' .DS. 'constants.php' );
   require_once ( 'classes' .DS. 'JoomooSitestyleColors.php' );
   require_once ( 'classes' .DS. 'JoomooSitestyleLimits.php' );
   require_once ( 'controllers' .DS. 'DatabaseController.php' );
   $dbController = new JoomooSitestyleDatabaseController( $save_by_ip );
   if ( $dbController->usingDb )
   {
     require_once ( 'models' .DS. 'DatabaseModel.php' );    // We have our own personal specialized model just for the template
     $includePath = JPATH_SITE .DS. 'templates' .DS. $this->template .DS. 'tables';
     JTable::addIncludePath( $includePath );                // enables JTable to find subclasses in tables subdir.
     $dbController->createParamsModel();
     $dbController->setDefaults(
         $default_background, $default_border_color_name, $default_border_style, $default_border_width, $default_font_size
     );
      // print "Using Db, calling dbController->getJoomooSitestyleParams():<br />\n";
      $dbController->getJoomooSitestyleParams();
   }
  ?>

 <?php
   // Require static class containing the color definitions and export values to javascript
   // This is where the colors and the defaults set in the backend get set in the javascript code
   // Also this is where we pass the cookie name and delimiter from constants.php to the javascript code
   //
   JoomooSitestyleColors::writeStyleSheet( $heading_color, $link_color, $input_color );
   JoomooSitestyleColors::writeBulletStyles( $this->baseurl, $this->template, $bullet_color );
//   JoomooSitestyleColors::exportToJavascript();
   JoomooSitestyleLimits::exportToJavascript();
   print '<script type="text/javascript">' . "\n";
   print ' //<![CDATA[ ' . "\n";
   print '  var JoomooSitestyle;' . "\n";
   print '  if ( ! JoomooSitestyle ) { JoomooSitestyle = {}; }' . "\n";
   print '  JoomooSitestyle.heading_color = JoomooSitestyle.heading_' . $heading_color . ';' . "\n";
   print '  JoomooSitestyle.link_color = JoomooSitestyle.link_' . $link_color . ';' . "\n";
   print '  JoomooSitestyle.default_background = "' . $default_background . '";' . "\n";
   print '  JoomooSitestyle.default_border_color_name = "' . $default_border_color_name . '";' . "\n";
   print '  JoomooSitestyle.default_border_style = "' . $default_border_style . '";' . "\n";
   print '  JoomooSitestyle.default_border_width = ' . $default_border_width . ";\n";
   print '  JoomooSitestyle.default_font_size = ' . $default_font_size . ";\n";
   print '  JoomooSitestyle.usingDb = ' . ($dbController->usingDb ? 'true' : 'false') . ";\n";
   print '  JoomooSitestyle.cookieName = "' . JOOMOO_SITESTYLE_COOKIE_NAME . '";' . "\n";
   print '  JoomooSitestyle.cookieDelimiter = "' . JOOMOO_SITESTYLE_COOKIE_DELIMITER . '";' . "\n";
   if ( $save_by_ip )
   {
      print '  JoomooSitestyle.save_by_ip = "' . $save_by_ip . '";' . "\n";
      print '  JoomooSitestyle.ip_address = "' . $dbController->getIpAddress() . '";' . "\n";
   }
   print ' //]]>' . "\n";
   print '</script>' . "\n";
   /*
    * Here's where we use either the stored or default values to write a stylesheet for users who have javascript turned off
    */
    if ( $dbController->usingDb )
    {
       $background = $dbController->background;
       $border_color_name = $dbController->border_color_name;
       $border_style = $dbController->border_style;
       $border_width = $dbController->border_width;
       $font_size = $dbController->font_size;
    }
    else
    {
       $background = $default_background;
       $border_color_name = $default_border_color_name;
       $border_style = $default_border_style;
       $border_width = $default_border_width;
       $font_size = $default_font_size;
    }
  ?>
  <?php if ( $background == 'image' ) : ?>
   <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/background_image.css" rel="stylesheet" type="text/css" />
  <?php else: ?>
   <style type="text/css">
    body { background-color: <?php echo JoomooSitestyleColors::$backgroundColor[$background] ?>; }
   </style>
  <?php endif; ?>
  <?php
   $largeElementWidth = $border_width;
   $mediumElementWidth = round( $border_width * 0.80 );
   $smallElementWidth = round( $border_width * 0.40 );
  ?>
  <style type="text/css">
   div#page_wrapper, div#header_wrapper, div#page_body,
   table.simple_pill, div#leftcolumn, td#rightcolumn, #footer {
      border-color: <?php echo JoomooSitestyleColors::$borderColor[$border_color_name] ?> ;
      border-style: <?php echo $border_style ?> ;
   }
   div#page_wrapper { border-width: <?php echo $largeElementWidth ?>px ; }
   div#header_wrapper { border-width: <?php echo $mediumElementWidth ?>px; }
   div#page_body { border-width: <?php echo $mediumElementWidth ?>px; }
   table.simple_pill { border-width: <?php echo $smallElementWidth ?>px; }
   div#leftcolumn { border-width: <?php echo $smallElementWidth ?>px; }
   td#rightcolumn { border-width: <?php echo $smallElementWidth ?>px; }
   #footer { border-width: <?php echo $smallElementWidth ?>px; }
   body { font-size: <?php echo $font_size ?>%; }
  </style>

 <!--[if lte IE 6]>
  <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
 <![endif]-->
 <?php if($this->direction == 'rtl') : ?>
  <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_rtl.css" rel="stylesheet" type="text/css" />
 <?php endif; ?>
 <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/mysite.css" type="text/css" />

</head>

<body id="page_bg">
<div class="center" align="center">
 <a name="up" id="up"></a>
 <div id="page_wrapper">
   <div id="tiptop">
    <jdoc:include type="modules" name="tiptop" style="rounded" />
   </div>
   <?php
    print '<script type="text/javascript">' . "\n";
    print ' //<![CDATA[ ' . "\n";
    if ( $dbController->usingDb )
    {
       print '  JoomooSitestyle.id = "' . $dbController->id . '";' . "\n";
       print '  JoomooSitestyle.background = "' . $dbController->background . '";' . "\n";
       print '  JoomooSitestyle.border_color_name  = "' . $dbController->border_color_name . '";' . "\n";
       print '  JoomooSitestyle.border_style  = "' . $dbController->border_style . '";' . "\n";
       print '  JoomooSitestyle.border_width  = ' . $dbController->border_width . ";\n";
       print '  JoomooSitestyle.font_size  = ' . $dbController->font_size . ";\n";
    }
    else
    {
       print '  JoomooSitestyle.getJoomooSitestyle();' . "\n";   // not using DB: get values from cookie
    }
    print '  JoomooSitestyle.setBackground ( JoomooSitestyle.background );    // best to set before drawing page' . "\n";
    print '  JoomooSitestyle.setFontSize   ( JoomooSitestyle.font_size );     // best to set before drawing page' . "\n";
    print ' //]]>' . "\n";
    print '</script>' . "\n";
   ?>

  <?php  // remove when not debugging
   // // this is a JDocumentHTML object
   // $this_class = get_class( $this );
   // print "this class = " . $this_class . "<br />";
   // print "Number of cookies stored: " . count($_COOKIE) . "<br />\n";
   // print '_COOKIE[' . JOOMOO_SITESTYLE_COOKIE_NAME. '] = ' . $_COOKIE[JOOMOO_SITESTYLE_COOKIE_NAME] . "<br />\n";
   // $showCookies = TRUE;
   $showCookies = FALSE;
   if ( $showCookies )
   {
      print "<br />\n";
      $count = 1;
      foreach ($_COOKIE as $index => $value)
      {
         print "cookie # $count: _COOKIE[$index]: \"" . $value . "\"<br />";
         $count++;
      }
   }
   // print '<br /><br />';
   // @print '_COOKIE["percentages_profile_score"] = "' . $_COOKIE['percentages_profile_score'] . '"<br />';
   // @print '_COOKIE["double_percentages"] = "' . $_COOKIE['double_percentages'] . '"<br />';
   // @print '_COOKIE["jung_profile_score"] = "' . $_COOKIE['jung_profile_score'] . '"<br />';
   // @print '_COOKIE["x_or_x"] = "' . $_COOKIE['x_or_x'] . '"<br />';
   // @print '_COOKIE["kts_profile_score"] = "' . $_COOKIE['kts_profile_score'] . '"<br />';
   // @print '_COOKIE["kts_image_score"] = "' . $_COOKIE['kts_profile_score'] . '"<br />';
  ?>

   <?php
    // if there is no ad in the tiptop position
    //    change the class of the header_left and header_right elements
    //
    $num_modules_tiptop = $this->countModules('tiptop');
    // print "num_modules_tiptop = $num_modules_tiptop<br />";
    if ( $num_modules_tiptop == 0 )
    {
      $header_left_class = 'header_noad_in_tiptop_pos';
      $header_right_class = 'header_noad_in_tiptop_pos';
    }
    else
    {
      $header_left_class = 'header_ad_in_tiptop_pos';
      $header_right_class = 'header_ad_in_tiptop_pos';
    }
   ?>
  <div id="header_wrapper">
    <div  id="header_left" class="<?php echo $header_left_class ?>">
      <jdoc:include type="modules" name="header_left" style="rounded" />
    </div>
    <div id="header_center">
      <?php if ( 0 < strlen($tag_line_above) ) : ?>
        <div id="tag_line_above"><?php echo $tag_line_above ?></div>
      <?php endif; ?>
      <?php if ( 0 < strlen($site_name) ) : ?>
        <div id="site_name">
          <a href="index.php" class="arrow site_name"><?php echo $site_name ?></a>
        </div>
      <?php endif; ?>
      <?php if ( 0 < strlen($tag_line_below) ) : ?>
        <div id="tag_line_below"><?php echo $tag_line_below ?></div>
      <?php endif; ?>
      <div id="news_flash">
        <jdoc:include type="modules" name="top" style="rounded" />
      </div>
    </div>
    <div id="header_right" class="<?php echo $header_right_class ?>">
      <jdoc:include type="modules" name="header_right" style="rounded" />
    </div>
  </div> <!-- close of div with id="header_wrapper" -->

  <table id="simple_pill" class="simple_pill">
   <tr>
    <td class="simple_pill_m">
     <div id="simple_pillmenu">
      <jdoc:include type="modules" name="user3" style="rounded" />
     </div>
    </td>
   </tr>
  </table>

  <div id="search">
   <jdoc:include type="modules" name="user4" style="rounded" />
  </div>
  <div id="pathway">
   <jdoc:include type="modules" name="breadcrumb" style="rounded" />
  </div>

  <div class="clr"></div> <!-- clears all floating elements -->

   <?php
//    $this_countModules_left = $this->countModules('left');
//    print "this_countModules_left = $this_countModules_left<br />";
//    $this_countModules_user1 = $this->countModules('user1');
//    print "this_countModules_user1 = $this_countModules_user1<br />";
//    $this_countModules_user2 = $this->countModules('user2');
//    print "this_countModules_user2 = $this_countModules_user2<br />";
//    $this_countModules_user1_or_user2 = $this->countModules('user1 or user2');
//    print "this_countModules_user1_or_user2 = $this_countModules_user1_or_user2<br />";
   ?>
  <div id="page_body">
   <jdoc:include type="message" />
    <?php if($this->countModules('left')) : ?>
     <div id="leftcolumn">
      <jdoc:include type="modules" name="left" style="rounded" />
     </div>
    <?php endif; ?>

  <?php if($this->countModules('left')) : ?>
   <div id="maincolumn">
  <?php else: ?>
   <div id="maincolumn_full">
  <?php endif; ?>

  <?php if($this->countModules('user1 or user2')) : ?>
    <table class="nopad user1user2">
     <tr valign="top">
      <?php if($this->countModules('user1')) : ?>
       <td>
        <jdoc:include type="modules" name="user1" style="xhtml" />
       </td>
      <?php endif; ?>
      <?php if($this->countModules('user1 and user2')) : ?>
       <td class="user1_user2_spacer">&nbsp;</td>
      <?php endif; ?>
      <?php if($this->countModules('user2')) : ?>
       <td>
        <jdoc:include type="modules" name="user2" style="xhtml" />
       </td>
       <?php endif; ?>
     </tr>
    </table>
    <div id="maindivider">
    </div>
  <?php endif; ?>

    <table class="nopad">
     <tr valign="top">
       <td>
        <jdoc:include type="component" />
       </td>
      <?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
       <td class="component_rightcolumn_spacer">&nbsp;</td>
       <td id="rightcolumn">
        <jdoc:include type="modules" name="right" style="rounded" />
       </td>
      <?php endif; ?>
     </tr>
    </table>
   </div> <!-- end of div with id="maincolumn" or "maincolumn_full" -->

   <div class="clr"></div>
   <div id="footerspacer"></div>
   <div id="footer">
    <div class="center">
     <div id="bannerbottom">
      <center>
       <jdoc:include type="modules" name="bannerbottom" style="rounded" />
      </center>
     </div>
    </div>
    <div class="footer_modules">
     <jdoc:include type="modules" name="footer" style="xhtml"/>
    </div>
    <table>
     <tr>
      <td id="syndicate">
       <jdoc:include type="modules" name="syndicate" />
      </td>
      <td id="copyright">
       <!-- this code is based on that in modules/mod_footer -->
       <!-- putting it here so I can center this text and put it in this table -->
       <!-- while putting banner ad in "real footer" area above -->
       <?php $app = JFactory::getApplication();
             $date =& JFactory::getDate();
             $cur_year = $date->toFormat('%Y');
             $csite_name = $app->getCfg('sitename');
             $copyright_line = "Copyright &copy; " . $cur_year . " " . $csite_name . ". All rights reserved.";
             print $copyright_line;
       ?>
      </td>
      <td id="power_by">
       <?php echo JText::_('Powered by') ?> <a href="http://www.joomla.org">Joomla!</a>.
      </td>
     </tr>
    </table>
   </div> <!-- close of div with id="footer" -->
  </div> <!-- close of div with id="page_body" -->
 </div> <!-- close of div with id="page_wrapper" -->
 <jdoc:include type="modules" name="debug" style="rounded" />
</div>

  <div style="margin-left: 30px">
   <script type="text/javascript">
    //<![CDATA[
    //
    // Set border styles only after page is drawn
    //
    JoomooSitestyle.setBorderColorName ( JoomooSitestyle.border_color_name );   // also sets JoomooSitestyle.border_color_value
    JoomooSitestyle.setBorderStyle     ( JoomooSitestyle.border_style );
    JoomooSitestyle.setBorderWidth     ( JoomooSitestyle.border_width );
    JoomooSitestyle.saveJoomooSitestyle();
    //]]>
   </script>
  </div>

</body>
</html>
