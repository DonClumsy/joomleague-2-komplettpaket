<?php defined('_JEXEC') or die('Restricted access');?>
		<div class="jl_rosterperson jl_rp<?php echo $this->k;?>">
<?php 
$personName = JoomleagueHelper::formatName(null ,$this->row->firstname, $this->row->nickname, $this->row->lastname, $this->config["name_format_staff"]);
if ($this->config['show_staff_icon']==1) 
{
	$imgTitle = JText::sprintf( $personName );
	$picture = $this->row->picture;
	if ((empty($picture)) || ($picture == 'images/com_joomleague/database/placeholders/placeholder_150_2.png' ))
	{
		$picture = $this->row->ppic;
	}
	if ( !file_exists( $picture ) )
	{
		$picture = 'images/com_joomleague/database/placeholders/placeholder_150_2.png';
	}
	/*
  $thumbnail = JoomleagueHelper::getPictureThumb($picture, $imgTitle,
		$this->config['staff_picture_width'],
		$this->config['staff_picture_height']
	);
	*/
?>
			<div class="jl_rosterperson_staffpicture_column">
				<div class="jl_roster_staffperson_pic">
<?php
if ( !$this->config['show_highslide'] )
		{
	//echo $thumbnail;
	echo JHTML::image($picture, $imgTitle, array('title' => $imgTitle,'width' => $this->config['staff_picture_width'] ));
    }
    else
			{
      ?>
<a href="<?php echo $picture;?>" alt="<?php echo $personName;?>" title="<?php echo $personName;?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?php echo $picture;?>" alt="<?php echo $personName;?>" title="zum Zoomen anklicken" width="<?php echo $this->config['staff_picture_width'];?>" /></a>
    <?php
      }	
    
?>
				</div><!-- /.jl_roster_staffperson_pic -->
			</div><!-- /.jl_rosterperson_staffpicture_column -->
<?php
}//if ($this->config['show_staff_icon']) ends
?>
		<div class="jl_roster_staffperson_detail_column">
			<h3>
				<span class="jl_rosterperson_name">
				<?php
		echo ($this->config['link_staff']==1) ? 
			JHTML::link(JoomleagueHelperRoute::getStaffRoute($this->project->slug,$this->team->slug,$this->row->slug),$personName)
			: $personName;
?>
					<br />&nbsp;
				</span>	
			</h3>
			<div class="jl_roster_persondetails">
					<div>
						<span class="jl_roster_persondetails_label">
<?php 
							echo JText::_('COM_JOOMLEAGUE_ROSTER_STAFF_FUNCTION');
?>
						</span><!-- /.jl_roster_persondetails_label -->
						<span class="jl_roster_persondetails_data">
<?php
						if (!empty($this->row->parentname)) {
						echo JText::sprintf('COM_JOOMLEAGUE_ROSTER_MEMBER_OF',JText::_($this->row->parentname));
						}
						echo $this->row->position;
						?>
						</span><!-- /.jl_roster_persondetails_data -->
					</div>
<?php 
	if ($this->config['show_birthday_staff'] > 0 AND $this->row->birthday !="0000-00-00") 
	{
		switch ($this->config['show_birthday_staff'])
		{
			case 1:	 // show Birthday and Age
				$showbirthday = 1;
				$showage = 1;
				$birthdayformat = JText::_('COM_JOOMLEAGUE_GLOBAL_DAYDATE');
				break;
			case 2:	 // show Only Birthday
				$showbirthday = 1;
				$showage = 0;
				$birthdayformat = JText::_('COM_JOOMLEAGUE_GLOBAL_DAYDATE');
				break;
			case 3:	 // show Only Age
				$showbirthday = 0;
				$showage = 1;
				break;
			case 4:	 // show Only Year of birth
				$showbirthday = 1;
				$showage = 0;
				$birthdayformat = JText::_('%Y');
				break;
			default:
				$showbirthday = 0;
				$showage = 0;
			break;
		}
		if ($showage == 1)
		{
?>
					<div>
						<span class="jl_roster_persondetails_label">
							<?php echo JText::_("COM_JOOMLEAGUE_PERSON_AGE");?>
						</span>
						<span class="jl_roster_persondetails_data">
							<?php echo JoomleagueHelper::getAge($this->row->birthday,$this->row->deathday);?>
						</span>
					</div>
<?php
		}
		if ($showbirthday == 1)
		{
?>
					<div>
						<span class="jl_roster_persondetails_label">
							<?php echo JText::_("COM_JOOMLEAGUE_PERSON_BIRTHDAY");?>
						</span>
						<span class="jl_roster_persondetails_data">
							<?php echo JHTML::date($this->row->birthday,$birthdayformat);?>
						</span>
					</div>
<?php
		}
		// deathday
		if ( $this->row->deathday !="0000-00-00" )
		{
?>
					<div>
						<span class="jl_roster_persondetails_label">
							<?php echo JText::_("COM_JOOMLEAGUE_PERSON_DEATHDAY");?>[ &dagger; ]
						</span>
						<span class="jl_roster_persondetails_data">
							<?php echo JHTML::date($this->row->deathday,JText::_('COM_JOOMLEAGUE_GLOBAL_DAYDATE'));?>
						</span>
					</div>
<?php
		}
	}// if ($this->config['show_birthday_staff'] > 0 AND $this->row->birthday !="0000-00-00") ends
	if ($this->config['show_country_flag_staff'])
	{
?>
					<div>
						<span class="jl_roster_persondetails_label">
							<?php echo JText::_("COM_JOOMLEAGUE_PERSON_NATIONALITY");?>
						</span><!-- /.jl_roster_persondetails_label -->
						<span class="jl_roster_persondetails_data">
<?php
			echo Countries::getCountryFlag($this->row->country);
?>
						</span><!-- /.jl_roster_persondetails_data -->
					</div>
<?php
	}// if ($this->config['show_country_flag']) ends
?>
				</div><!-- /.jl_roster_persondetails -->
			</div><!-- /.jl_roster_staffperson_detail_column -->
		</div><!-- /.jl_rp<?php echo $this->k;?> -->