<?php
/**
 * @version     $Id: joomoositestyle.php,v 1.4 2009/05/19 22:09:56 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JPATH_SITE.DS.'components'.DS.'com_joomoobase'.DS.'controllers'.DS.'joomoobase.php' );
require_once( JPATH_SITE.DS.'components'.DS.'com_joomoobase'.DS.'models'.DS.'joomoobaseDb.php' );
require_once( JPATH_COMPONENT.DS.'controllers'.DS.'joomoositestyle.php' );
require_once( JPATH_COMPONENT.DS.'models'.DS.'joomoositestyle.php' );

JTable::addIncludePath( JPATH_COMPONENT.DS.'tables' );  // enables JTable to find subclasses in tables subdir.

$controller = new JoomooSitestyleController( );

$controller->execute( JRequest::getVar( 'task' ) );   // Perform the Request task
$controller->redirect();                              // Redirect if set by the controller
?>
