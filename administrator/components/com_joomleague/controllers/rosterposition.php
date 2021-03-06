<?php
/**
* @copyright	Copyright (C) 2007 JoomLeague.net. All rights reserved.
* @license		GNU/GPL,see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License,and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
//require_once (JPATH_COMPONENT.DS.'controllers'.DS.'joomleague.php');

/**
 * Joomleague Component League Controller
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueControllerrosterposition extends JoomleagueController
{

protected $view_list = 'rosterpositions';

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('addhome','display');
    $this->registerTask('addaway','display');
		$this->registerTask('edit','display');
		$this->registerTask('apply','save');
	}

	function display()
	{
	$option = JRequest::getCmd('option');

		$mainframe	= JFactory::getApplication();
		$document = JFactory::getDocument();
		
		switch ($this->getTask())
		{
			case 'addhome'	 :
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','rosterposition');
				JRequest::setVar('edit',false);
        JRequest::setVar('addposition','HOME_POS');
				// Checkout the project
				$model=$this->getModel('rosterposition');
				$model->checkout();
			} break;
      case 'addaway'	 :
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','rosterposition');
				JRequest::setVar('edit',false);
        JRequest::setVar('addposition','AWAY_POS');
				// Checkout the project
				$model=$this->getModel('rosterposition');
				$model->checkout();
			} break;
			case 'edit'	:
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','rosterposition');
				JRequest::setVar('edit',true);
				// Checkout the project
				$model=$this->getModel('rosterposition');
				$model->checkout();
			} break;
		}
		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(0),'post','array');
		$post['id']=(int) $cid[0];
		$model=$this->getModel('rosterposition');
		if ($model->store($post))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_ROSTERPOSITIONS_CTRL_SAVED');
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_ROSTERPOSITIONS_CTRL_ERROR_SAVE').$model->getError();
		}
		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		if ($this->getTask()=='save')
		{
			$link='index.php?option=com_joomleague&view=rosterpositions&task=rosterposition.display';
		}
		else
		{
			$link='index.php?option=com_joomleague&task=rosterposition.edit&cid[]='.$post['id'];
		}
		$this->setRedirect($link,$msg);
	}

	function remove()
	{
		JRequest::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TO_DELETE'));}
		$model=$this->getModel('rosterposition');
		if (!$model->delete($cid))
		{
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
			return;
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_ROSTERPOSITIONS_CTRL_DELETED');
		}
		$this->setRedirect('index.php?option=com_joomleague&view=rosterpositions&task=rosterposition.display',$msg);
	}

	function cancel()
	{
		// Checkin the project
		$model=$this->getModel('rosterposition');
		$model->checkin();
		$this->setRedirect('index.php?option=com_joomleague&view=rosterpositions&task=rosterposition.display');
	}

	function orderup()
	{
		$model=$this->getModel('rosterposition');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_joomleague&view=rosterpositions&task=rosterposition.display');
	}

	function orderdown()
	{
		$model=$this->getModel('rosterposition');
		$model->move(1);
		$this->setRedirect('index.php?option=com_joomleague&view=rosterpositions&task=rosterposition.display');
	}

	function saveorder()
	{
		JRequest::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$cid=JRequest::getVar('cid',array(),'post','array');
		$order=JRequest::getVar('order',array(),'post','array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
		$model=$this->getModel('rosterposition');
		$model->saveorder($cid,$order);
		$msg=JText::_('COM_JOOMLEAGUE_GLOBAL_NEW_ORDERING_SAVED');
		$this->setRedirect('index.php?option=com_joomleague&view=rosterpositions&task=rosterposition.display',$msg);
	}

	function import()
	{
		JRequest::setVar('view','import');
		JRequest::setVar('table','rosterposition');
		parent::display();
	}
	
	function export()
	{
		JRequest::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TO_EXPORT'));}
		$model = $this->getModel("rosterposition");
		$model->export($cid, "rosterposition", "rosterposition");
	}
	
	/**
	 * Proxy for getModel
	 *
	 * @param	string	$name	The model name. Optional.
	 * @param	string	$prefix	The class prefix. Optional.
	 *
	 * @return	object	The model.
	 * @since	1.6
	 */
	function getModel($name = 'rosterposition', $prefix = 'JoomleagueModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
}
?>