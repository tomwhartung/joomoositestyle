<?php
/**
 * @version     $Id: controller.php,v 1.20 2009/05/18 17:28:59 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * joomoositestyle Component Controller
 *
 */
class JoomoositestyleController extends JController
{
	/**
	 * Method to display the view
	 * (Getting this from http://docs.joomla.org/Tutorial:Adding_Javascript_moo.fx_to_your_component_WIP)
	 */
	public function display()
	{
		//	global $mainframe;       // replaced by $app in 1.7.3
		$app = JFactory::getApplication();
		$document =& JFactory::getDocument();  // JDocumentHTML object

		$baseDirectory = $app->getCfg('live_site');
		$componentName = $app->scope;
		$templateName  = $app->getTemplate();

		//
		//	$app_class = get_class( $app );     // JSite object
		//	print "app_class = " . $app_class  . "<br />\n";
		//	$document_class = get_class( $document );     // JDocumentHTML object
		//	print "document_class = " . $document_class  . "<br />\n";
		//
		// Add the js-files
		//
		$document->addScript( $baseDirectory .DS. 'media' .DS. 'system' .DS. 'js' .DS. 'mootools-core.js');
		$document->addScript( $baseDirectory .DS. 'media' .DS. 'system' .DS. 'js' .DS. 'mootools-more.js');
		$document->addScript( $baseDirectory .DS. 'media' .DS. 'system' .DS. 'js' .DS. 'caption.js');
		$document->addScript(  DS. 'components' .DS. 'com_joomoobase' .DS. 'javascript' .DS. 'JoomooRequest.js');
		$document->addScript( $baseDirectory .DS. 'components' .DS. $componentName .DS. 'assets' .DS. 'ViewFunctions.js');

		parent::display();
	}
}
?>
