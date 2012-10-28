<?php
/**
 * @version     $Id: joomoositestyle.php,v 1.8 2008/10/28 18:29:53 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once (JPATH_COMPONENT.DS.'controller.php');   // Load the controller code

$controller = new JoomooSitestyleController( );       // Create the controller

$controller->execute(JRequest::getCmd('task'));       // Perform the Request task

$controller->redirect();                              // Redirect if set by the controller
?>
