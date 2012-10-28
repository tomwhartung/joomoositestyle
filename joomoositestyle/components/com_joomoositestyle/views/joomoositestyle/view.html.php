<?php
/**
 * @version     $Id: view.html.php,v 1.11 2008/10/31 17:56:15 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the joomoositestyle component
 */
class JoomooSitestyleViewJoomooSitestyle extends JView
{
	function display($tpl = null)
	{
		//	print "Hello from JoomooSitestyleViewJoomooSitestyle::display() (in view.html.php)<br />\n";

		JHTML::_('stylesheet', 'joomoositestyle.css', 'components/com_joomoositestyle/assets/');

		$app = JFactory::getApplication();
		$params	= &$app->getParams();       // Get the parameters of the active menu item
		$this->assignRef('params', $params);

		$model =& $this->getModel();
		parent::display($tpl);
	}
}
