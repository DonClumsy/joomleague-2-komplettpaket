<?php 
defined( '_JEXEC' ) or die( 'Restricted access' ); 
JHTML::_('behavior.mootools');
$modalheight = JComponentHelper::getParams('com_joomleague')->get('modal_popup_height', 600);
$modalwidth = JComponentHelper::getParams('com_joomleague')->get('modal_popup_width', 900);


?>
<table width="100%" class="contentpaneopen">
	<tr>
		<td class="contentheading">
			<?php
			echo $this->title;
			
			
			if ( $this->showediticon )
	{
		/*
    $link = JoomleagueHelperRoute::getPlayerRoute( $this->project->id, $this->teamPlayer->team_id, $this->person->id, 'person.edit' );
		$desc = JHTML::image(
			"media/com_joomleague/jl_images/edit.png",
			JText::_( 'COM_JOOMLEAGUE_PERSON_EDIT' ),
			array( "title" => JText::_( "COM_JOOMLEAGUE_PERSON_EDIT" ) )
		);
	    echo " ";
	    echo JHTML::_('link', $link, $desc );
	    */
	
	?>   
	             <a	rel="{handler: 'iframe',size: {x: <?php echo $modalwidth; ?>,y: <?php echo $modalheight; ?>}}"
									href="index.php?option=com_joomleague&tmpl=component&view=editperson&cid=<?php echo $this->person->id; ?>"
									 class="modal">
									<?php
									echo JHTML::_(	'image','administrator/components/com_joomleague/assets/images/edit.png',
													JText::_('COM_JOOMLEAGUE_PERSON_EDIT'),'title= "' .
													JText::_('COM_JOOMLEAGUE_PERSON_EDIT').'"');
									?>
								</a>
                <?PHP
                
  }
  ?>
		</td>
	</tr>
</table>

