<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<table class="contentpaneopen">
	<tr>
		<td class="contentheading">
		<?php
		if ( $this->config['show_team_shortform'] == 1 && !empty($this->team->short_name))
		{
			echo '&nbsp;' . JText::sprintf( 'COM_JOOMLEAGUE_ROSTER_TITLE2', $this->team->name, $this->team->short_name );
		}
		else
		{
			echo '&nbsp;' . JText::sprintf( 'COM_JOOMLEAGUE_ROSTER_TITLE', $this->team->name );
		}
		?>
		</td>
        
        
        
		<form name='resultsRoundSelector' method='post'>
		<input type='hidden' name='option' value='com_joomleague' />
        <?php
        echo "<td>".JHTML::_('select.genericlist', $this->lists['type'], 'type' , 'class="inputbox" size="1" onchange="this.form.submit();" ', 'value', 'text', $this->type )."</td>";
        ?>
        </form>
	</tr>
</table>
<br />
