<?php
/**
 * @version     $Id: default.php,v 1.15 2009/05/20 00:07:55 tomh Exp tomh $
 * @author      Tom Hartung <webmaster@tomhartung.com>
 * @package     Joomla
 * @subpackage  Joomoositestyle
 * @copyright   Copyright (C) 2008 Tom Hartung. All rights reserved.
 * @since       1.5
 * @license     GNU/GPL, see LICENSE.php
 */
/*
 * default.php: when task not handled by controller (e.g., it's blank), display rows from table
 * --------------------------------------------------------------------------------------------
 * call model code to get data from DB
 * call function defined in this file to produce the HTML
 */

defined( '_JEXEC' ) or die( 'Restricted access' );      // no direct access
// print "Hello from tmpl/default.php.<br />\n";

JToolBarHelper::title( JText::_( 'Joomoo Site Style: View Database Records' ), 'generic.png' );
$document = & JFactory::getDocument();
$document->setTitle(JText::_('Joomoo Site Style: View Database Records'));

//
// Get data from the model and list the rows
//
// $tableName  =& $this->get( 'tableName'  );    // calls getTableName () in the model
$rows       =& $this->get( 'Rows' );             // calls getRows() in the model
$pagination =& $this->get( 'Pagination' );       // calls getPagination() in the model
$lists      =& $this->get( 'lists' );            // calls getLists() in the model

listRows( $rows, $pagination, $lists );

/**
 * outputs HTML to display the list of rows
 * @return void
 */
function listRows( $rows, $pagination, $lists )
{
	$option = JRequest::getCmd('option');

	// print "listRows function: option: \"" . $option . "\"<br />\n";

	jimport( 'joomla.filter.output' );

	$rowCount = count( $rows );
	$rowClassSuffix = 0;
	$maxCharsInDesc = 200;

	print '<form action="index.php" method="post" name="adminForm" id="adminForm">' . "\n";

	print ' <table class="adminlist">' . "\n";
	print '  <tr>' . "\n";
	print '   <th width="10%" style="text-align: right">';
	echo  JHTML::_('grid.sort', 'Id', 'id', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="10%" style="text-align: left">';
	echo  JHTML::_('grid.sort', 'Userid', 'user_id', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="15%" style="text-align: center">';
	echo  JHTML::_('grid.sort', 'IP Address', 'ip_address', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="10%" style="text-align: center">';
	echo  JHTML::_('grid.sort', 'Background', 'background', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="10%" style="text-align: center">';
	echo  JHTML::_('grid.sort', 'Border Color', 'border_color_name', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="15%" style="text-align: center">';
	echo  JHTML::_('grid.sort', 'Border Style', 'border_style', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="10%" style="text-align: center">';
	echo  JHTML::_('grid.sort', 'Border Width', 'border_width', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="10%" style="text-align: center">';
	echo  JHTML::_('grid.sort', 'Font Size', 'font_size', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '   <th width="10%" style="text-align: center">';
	echo  JHTML::_('grid.sort', 'Timestamp', 'timestamp', $lists['order_Dir'], $lists['order']);
	print '</th>' . "\n";

	print '  </tr>' . "\n";

	for ( $rowNum = 0; $rowNum < $rowCount; $rowNum++ )
	{
		$row =& $rows[$rowNum];
		$checked = JHTML::_( 'grid.id', $rowNum, $row->id );

		print '  <tr class="row' . $rowClassSuffix . '">' . "\n";
		print '   <td style="text-align: right">' . $row->id . "</td>\n";
		print '   <td style="text-align: center">' . $row->user_id . "</td>\n";
		print '   <td style="text-align: right">'  . $row->ip_address . "</td>\n";
		print '   <td style="text-align: right">'  . $row->background . "</td>\n";
		print '   <td style="text-align: left">'   . $row->border_color_name . "</td>\n";
		print '   <td style="text-align: left">'   . $row->border_style . "</td>\n";
		print '   <td style="text-align: left">'   . $row->border_width . "</td>\n";
		print '   <td style="text-align: center">' . $row->font_size . "</td>\n";
		print '   <td style="text-align: center">' . $row->timestamp . "</td>\n";
		print '  </tr>' . "\n";

		$rowClassSuffix = 1 - $rowClassSuffix;      // alternates between values of 0 and 1 (to no avail!)
	}

	if ( is_a($pagination, 'JPagination') )
	{
		print '  <tfoot>' . "\n";
		print '   <td colspan="9">' . $pagination->getListFooter() . "\n";
		print '   </td>' . "\n";
		print '  </tfoot>' . "\n";
	}
	else
	{
		$pagination_class_name = get_class($pagination);
		print '  <tfoot>' . "\n";
		print '   <td colspan="9">' . "\n";
		print '     Oops, WTF, pagination is a member of the "' . $pagination_class_name . '" class?!?';
		print '   </td>' . "\n";
		print '  </tfoot>' . "\n";
	}

	print ' </table>' . "\n";

	print ' <input type="hidden" name="option" value="' . $option . '" />' . "\n";
	print ' <input type="hidden" name="task" value="" />' . "\n";
	print ' <input type="hidden" name="boxchecked" value="0" />' . "\n";

	if ( is_a($pagination, 'JPagination') )
	{
		print ' <input type="hidden" name="list_limit" value="' . $pagination->limit . '" />' . "\n";
	}

//	print ' <input type="hidden" name="filter_order" value="';
//	print    $lists['order'] . '" />' . "\n";
//	print ' <input type="hidden" name="filter_order_Dir" value="';
//	print    $lists['order_Dir'] . '" />' . "\n";

	print '</form>' . "\n";
	print '' . "\n";
}
?>
