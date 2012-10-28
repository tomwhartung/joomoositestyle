<?php
/**
* @version		$Id: mod_joomoositestyle.php,v 1.3 2009/05/12 01:29:58 tomh Exp tomh $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// // This is a JDocumentRendererModule object
// $this_class = get_class( $this );
// print "Hi from mod_joomoositestyle.php: this class = " . $this_class . "<br />\n";

$app = JFactory::getApplication();     // JSite object
$document =& JFactory::getDocument();  // JDocumentHTML object
$baseDirectory = $app->getCfg('live_site');
$templateName  = $app->getTemplate();

$document->addScript( $baseDirectory .DS. 'components' .DS. 'com_joomoobase' .DS. 'javascript' .DS. 'JoomooRequest.js' );
$document->addScript( $baseDirectory .DS. 'templates' .DS. $templateName .DS. 'javascript' .DS. 'ViewFunctions.js' );

require(JModuleHelper::getLayoutPath('mod_joomoositestyle'));
