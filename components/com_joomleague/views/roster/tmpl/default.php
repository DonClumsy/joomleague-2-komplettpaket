<?php defined( '_JEXEC' ) or die( 'Restricted access' );

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('projectheading', 'backbutton', 'footer');
JoomleagueHelper::addTemplatePaths($templatesToLoad, $this);

if ( $this->config['show_staff_layout'] == 'staff_johncage' || 
$this->config['show_players_layout']=='player_johncage' )
{
// johncage css:
$css = "";
if (count($this->rows > 0)) 
{
	if ($this->config['show_player_icon'])
	{
		$css .= ".jl_rp0 .jl_rosterperson_picture_column,.jl_rosterperson_pic > img, .jl_rosterperson_pic
		{
		width: ".$this->config['player_picture_width']."px;
		/*height:".$this->config['player_picture_height']."px;*/
		}
		.jl_rp1 .jl_rosterperson_detail_column
		{
		/*height:".$this->config['player_picture_height']."px;*/
		margin-right:".($this->config['player_picture_width']+10)."px;
		}
		";
	}//if ($this->config['show_player_icon']) ends
	$InOutStats = array();
	$InOutStats[1] = array('icon' => 'media/com_joomleague/event_icons/shirt.png');
	$InOutStats[2] = array('icon' => 'media/com_joomleague/event_icons/startroster.png');
	$InOutStats[3] = array('icon' => 'media/com_joomleague/event_icons/in.png');
	$InOutStats[4] = array('icon' => 'media/com_joomleague/event_icons/out.png');
	for ($x=count($InOutStats);$x>=1;$x--)
	{
		$css .= ".jl_roster_in_out$x { 
		background: #0a0 url('".JURI::base().$InOutStats[$x]['icon']."') left top  no-repeat;
		-moz-background-size: 14px;
		-o-background-size: 14px;
		-webkit-background-size: 14px; 
		-khtml-background-size: 14px;  
		background-size: 14px;
	}\n";
	}//for ($x=count($InOutStats);$x>=1;$x--) ends
	unset($InOutStats);
	if ($this->config['show_events_stats'] AND $this->positioneventtypes) 
	{
		$positions = array_keys($this->rows);
		$eventtypes_done = array();
		foreach ($positions AS $position_id)
		{
			foreach ((array)$this->positioneventtypes[$position_id] AS $eventtype)
			{
				if (!in_array($eventtype->eventtype_id, $eventtypes_done))
				{
					$iconPath=$eventtype->icon;
					if (!strpos(' '.$iconPath,'/'))
					{
						$iconPath='media/com_joomleague/event_icons/'.$iconPath;
					}
					$css .= ".jl_roster_event".$eventtype->eventtype_id." { 
					background: #ddd url('".JURI::base().$iconPath."') left top  no-repeat;
					-moz-background-size: 12px;
					-o-background-size: 12px;
					-webkit-background-size: 12px; 
					-khtml-background-size: 12px;  
					background-size: 12px;
					}\n";
					$eventtypes_done[] = $eventtype->eventtype_id;
				}
			}
		}
		unset($positions);
		unset($eventtypes_done);
	}//if ($this->config['show_events_stats'] AND $this->positioneventtypes) ends
}//if (count($this->rows > 0)) ends

if (count($this->stafflist) > 0 AND $this->config['show_staff_icon']==1)
{
		$css .= ".jl_rp0 .jl_rosterperson_staffpicture_column,.jl_roster_staffperson_pic > img, .jl_roster_staffperson_pic
		{
		width: ".$this->config['staff_picture_width']."px;
		/*height:".$this->config['staff_picture_height']."px;*/
		}
		.jl_rp1 .jl_roster_staffperson_detail_column
		{
		/*height:".$this->config['staff_picture_height']."px;*/
		margin-right:".($this->config['staff_picture_width']+10)."px;
		}
		";
}

if (!empty($css))
{
	$doc = &JFactory::getDocument();
	$doc->addStyleDeclaration($css);
}
// johncage css ends    
}



?>
<div class="joomleague">
	<?php 
	if ($this->config['show_projectheader'] == 1)
	{
		echo $this->loadTemplate('projectheading');
	}

	if ($this->projectteam)
	{
		if (($this->config['show_sectionheader'])==1)
		{
			echo $this->loadTemplate('sectionheader');
		}

		if (($this->config['show_team_logo'])==1)
		{
			echo $this->loadTemplate('picture');
		}

		if (($this->config['show_description'])==1)
		{
			echo $this->loadTemplate('description');
		}

		if (($this->config['show_players'])==1)
		{
			if (($this->config['show_players_layout'])=='player_standard')
			{
				echo $this->loadTemplate('players');
			} else if (($this->config['show_players_layout'])=='player_card') {
				$document 	= JFactory::getDocument();
				$option 	= JRequest::getCmd('option');
				$version 	= urlencode(JoomleagueHelper::getVersion());
				$document->addStyleSheet(  $this->baseurl . '/components/'.$option.'/assets/css/'.$this->getName().'_card.css?v=' . $version );
				echo $this->loadTemplate('players_card');
			}
			else if (($this->config['show_players_layout'])=='player_johncage') {
			$document 	= JFactory::getDocument();
			$option 	= JRequest::getCmd('option');
			$version 	= urlencode(JoomleagueHelper::getVersion());
			$document->addStyleSheet(  $this->baseurl . '/components/'.$option.'/assets/css/'.$this->getName().'_johncage.css?v=' . $version );
			echo $this->loadTemplate('players_johncage');
//            echo $this->loadTemplate('person_player');
			}
		}

		if (($this->config['show_staff'])==1)
		{
			if (($this->config['show_staff_layout'])=='staff_standard')
			{
				echo $this->loadTemplate('staff');
			} else if (($this->config['show_staff_layout'])=='staff_card') {
				$document 	= JFactory::getDocument();
				$option 	= JRequest::getCmd('option');
				$version 	= urlencode(JoomleagueHelper::getVersion());
				$document->addStyleSheet(  $this->baseurl . '/components/'.$option.'/assets/css/'.$this->getName().'_card.css?v=' . $version );
				echo $this->loadTemplate('staff_card');
			}
			else if (($this->config['show_staff_layout'])=='staff_johncage') {
			$document 	= JFactory::getDocument();
			$option 	= JRequest::getCmd('option');
			$version 	= urlencode(JoomleagueHelper::getVersion());
			$document->addStyleSheet(  $this->baseurl . '/components/'.$option.'/assets/css/'.$this->getName().'_johncage.css?v=' . $version );
			echo $this->loadTemplate('staff_johncage');
//            echo $this->loadTemplate('person_staff');
            
			}
		}
	}
	else
	{
		echo "<p>Project team could not be determined</p>";
	}

	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>
