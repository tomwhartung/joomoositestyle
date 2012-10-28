<?php
/**
 * @version     $Id: joomoositestyle.php,v 1.1 2009/05/19 22:08:52 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  JoomooSitestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * controller for the JoomooSitestyle component
 */
class JoomooSitestyleController extends JoomooBaseController
{
	/**
	 * Constructor: set model name in parent class
	 */
	public function __construct( $default = array() )
	{
		parent::__construct( $default );
		$this->_modelName = 'JoomooSitestyle';
	}

	/**
	 * get model and view for component and call display() in view
	 * --> called by framework when task is not handled by another method in this class (i.e. when task is blank)
	 * @access public
	 * @return void
	 */
	public function display()
	{
		// print "Hello from JoomooSitestyleController::display()<br />\n";

		$model =& $this->getModel( $this->getModelName() );           // instantiates model class

		$view  =& $this->getView( 'JoomooSitestyle', 'html' );        // 'html': use view.html.php (not view.php)
		$view->setModel( $model, true );                              // true: this is the default model

		$view->display();
	}
}
?>
